<?php
namespace App\Models;

use PDO;
use Exception;

class Order extends BaseModel {
    protected static string $table = 'orders';

    public static function createOrder(array $cartTotals, array $customerData, array $shippingAddress, string $paymentMethod, ?string $customerNotes = null): array {
        $db = self::db();
        $db->beginTransaction();

        try {
            $orderNumber = 'NUC-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -4));

            $orderSql = "INSERT INTO orders (
                order_number, customer_id, guest_email, subtotal, tax_amount, 
                shipping_amount, discount_amount, total_amount, coupon_code, 
                status, payment_status, payment_method, shipping_address_json, 
                billing_address_json, customer_notes
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

            $stmt = $db->prepare($orderSql);
            $stmt->execute([
                $orderNumber,
                $customerData['id'] ?? null,
                $customerData['email'] ?? null,
                $cartTotals['subtotal'],
                0.00,
                $cartTotals['shipping'],
                $cartTotals['discount'],
                $cartTotals['total'],
                $cartTotals['coupon_code'] ?? null,
                'pending',
                ($paymentMethod === 'cod') ? 'pending' : 'pending',
                $paymentMethod,
                json_encode($shippingAddress),
                json_encode($shippingAddress),
                $customerNotes
            ]);

            $orderId = (int)$db->lastInsertId();

            // Insert items
            $itemStmt = $db->prepare("INSERT INTO order_items (
                order_id, product_id, variant_id, product_title, variant_title, sku, quantity, unit_price, total_price
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

            $stockStmt = $db->prepare("UPDATE products SET stock_quantity = GREATEST(0, stock_quantity - ?) WHERE id = ?");

            foreach ($cartTotals['items'] as $item) {
                $lineTotal = (float)$item['unit_price'] * (int)$item['quantity'];
                $itemStmt->execute([
                    $orderId,
                    $item['product_id'],
                    $item['variant_id'] ?? null,
                    $item['title'],
                    $item['size_volume'] ?? '',
                    'SKU-' . $item['product_id'],
                    $item['quantity'],
                    $item['unit_price'],
                    $lineTotal
                ]);

                // Deduct stock
                $stockStmt->execute([$item['quantity'], $item['product_id']]);
            }

            // Record status history
            $histStmt = $db->prepare("INSERT INTO order_status_history (order_id, status, notes) VALUES (?, 'pending', 'Order placed by customer')");
            $histStmt->execute([$orderId]);

            // If coupon was used, record usage
            if (!empty($cartTotals['coupon_code'])) {
                $coupon = Coupon::findBy('code', $cartTotals['coupon_code']);
                if ($coupon) {
                    $db->prepare("INSERT INTO coupon_usage (coupon_id, order_id, customer_id, discount_applied) VALUES (?, ?, ?, ?)")
                       ->execute([$coupon['id'], $orderId, $customerData['id'] ?? null, $cartTotals['discount']]);
                    $db->prepare("UPDATE coupons SET times_used = times_used + 1 WHERE id = ?")
                       ->execute([$coupon['id']]);
                }
            }

            $db->commit();

            return self::find($orderId);
        } catch (Exception $e) {
            $db->rollBack();
            throw $e;
        }
    }

    public static function getWithDetails(int $orderId): ?array {
        $order = self::find($orderId);
        if (!$order) return null;

        $stmt = self::db()->prepare("SELECT * FROM order_items WHERE order_id = ?");
        $stmt->execute([$orderId]);
        $order['items'] = $stmt->fetchAll();

        $stmt = self::db()->prepare("SELECT * FROM order_status_history WHERE order_id = ? ORDER BY id ASC");
        $stmt->execute([$orderId]);
        $order['history'] = $stmt->fetchAll();

        $stmt = self::db()->prepare("SELECT * FROM shipments WHERE order_id = ? ORDER BY id DESC LIMIT 1");
        $stmt->execute([$orderId]);
        $order['shipment'] = $stmt->fetch() ?: null;

        return $order;
    }

    public static function getByCustomer(int $customerId): array {
        $stmt = self::db()->prepare("SELECT * FROM orders WHERE customer_id = ? ORDER BY id DESC");
        $stmt->execute([$customerId]);
        return $stmt->fetchAll();
    }

    public static function updateStatus(int $orderId, string $status, ?string $notes = null, ?int $adminId = null): void {
        self::update($orderId, ['status' => $status]);
        $stmt = self::db()->prepare("INSERT INTO order_status_history (order_id, status, notes, created_by_admin_id) VALUES (?, ?, ?, ?)");
        $stmt->execute([$orderId, $status, $notes, $adminId]);
    }

    public static function updatePayment(int $orderId, string $status, ?string $gatewayPaymentId = null, ?string $rawPayload = null): void {
        self::update($orderId, ['payment_status' => $status]);

        if ($gatewayPaymentId) {
            $stmt = self::db()->prepare("INSERT INTO payments (order_id, payment_method, gateway_payment_id, amount, status, response_payload) 
                                         VALUES (?, 'razorpay', ?, (SELECT total_amount FROM orders WHERE id = ?), ?, ?)");
            $stmt->execute([$orderId, $gatewayPaymentId, $orderId, ($status === 'paid' ? 'successful' : 'failed'), $rawPayload]);
        }
    }

    public static function getKpis(): array {
        $db = self::db();
        $totalRevenue = (float)$db->query("SELECT SUM(total_amount) FROM orders WHERE payment_status = 'paid' OR status = 'delivered'")->fetchColumn() ?: 0.0;
        $todayRevenue = (float)$db->query("SELECT SUM(total_amount) FROM orders WHERE DATE(created_at) = CURDATE() AND (payment_status = 'paid' OR status = 'delivered')")->fetchColumn() ?: 0.0;
        $totalOrders = (int)$db->query("SELECT COUNT(*) FROM orders")->fetchColumn();
        $pendingOrders = (int)$db->query("SELECT COUNT(*) FROM orders WHERE status = 'pending'")->fetchColumn();
        $processingOrders = (int)$db->query("SELECT COUNT(*) FROM orders WHERE status = 'processing'")->fetchColumn();
        $deliveredOrders = (int)$db->query("SELECT COUNT(*) FROM orders WHERE status = 'delivered'")->fetchColumn();
        $cancelledOrders = (int)$db->query("SELECT COUNT(*) FROM orders WHERE status = 'cancelled'")->fetchColumn();
        $totalCustomers = (int)$db->query("SELECT COUNT(*) FROM customers")->fetchColumn();
        $totalProducts = (int)$db->query("SELECT COUNT(*) FROM products WHERE is_active = 1")->fetchColumn();
        $lowStockProducts = (int)$db->query("SELECT COUNT(*) FROM products WHERE stock_quantity <= low_stock_threshold")->fetchColumn();

        return [
            'total_revenue' => $totalRevenue,
            'today_revenue' => $todayRevenue,
            'total_orders' => $totalOrders,
            'pending_orders' => $pendingOrders,
            'processing_orders' => $processingOrders,
            'delivered_orders' => $deliveredOrders,
            'cancelled_orders' => $cancelledOrders,
            'total_customers' => $totalCustomers,
            'total_products' => $totalProducts,
            'low_stock_products' => $lowStockProducts,
        ];
    }
}
