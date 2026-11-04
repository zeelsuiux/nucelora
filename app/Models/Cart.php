<?php
namespace App\Models;

use App\Helpers\Session;
use PDO;

class Cart extends BaseModel {
    protected static string $table = 'carts';

    public static function getOrCreate(?string $sessionToken = null, ?int $customerId = null): array {
        if (!$sessionToken) {
            Session::start();
            $sessionToken = Session::get('cart_token');
        }

        $cart = null;
        if ($customerId) {
            $cart = self::findBy('customer_id', $customerId);
        }
        if (!$cart && $sessionToken) {
            $cart = self::findBy('session_token', $sessionToken);
        }

        if (!$cart) {
            $id = self::insert([
                'session_token' => $sessionToken,
                'customer_id' => $customerId,
            ]);
            $cart = self::find($id);
        } elseif ($customerId && empty($cart['customer_id'])) {
            self::update($cart['id'], ['customer_id' => $customerId]);
            $cart['customer_id'] = $customerId;
        }

        return $cart;
    }

    public static function getItems(int $cartId): array {
        $sql = "SELECT ci.*, p.title, p.slug, p.price as current_price, p.compare_at_price, p.stock_quantity, p.size_volume, pi.image_url
                FROM cart_items ci
                JOIN products p ON p.id = ci.product_id
                LEFT JOIN product_images pi ON pi.product_id = p.id AND pi.is_primary = 1
                WHERE ci.cart_id = ?
                ORDER BY ci.id DESC";
        $stmt = self::db()->prepare($sql);
        $stmt->execute([$cartId]);
        return $stmt->fetchAll();
    }

    public static function addItem(int $cartId, int $productId, ?int $variantId = null, int $quantity = 1): void {
        $product = Product::find($productId);
        if (!$product || $product['is_active'] != 1) {
            throw new \Exception("Product is not available");
        }

        $stmt = self::db()->prepare("SELECT * FROM cart_items WHERE cart_id = ? AND product_id = ? LIMIT 1");
        $stmt->execute([$cartId, $productId]);
        $existing = $stmt->fetch();

        if ($existing) {
            $newQty = $existing['quantity'] + $quantity;
            $stmt = self::db()->prepare("UPDATE cart_items SET quantity = ?, unit_price = ? WHERE id = ?");
            $stmt->execute([$newQty, $product['price'], $existing['id']]);
        } else {
            $stmt = self::db()->prepare("INSERT INTO cart_items (cart_id, product_id, variant_id, quantity, unit_price) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$cartId, $productId, $variantId, $quantity, $product['price']]);
        }
    }

    public static function updateQuantity(int $cartId, int $productId, int $quantity): void {
        if ($quantity <= 0) {
            self::removeItem($cartId, $productId);
            return;
        }

        $product = Product::find($productId);
        if (!$product) return;

        $stmt = self::db()->prepare("UPDATE cart_items SET quantity = ?, unit_price = ? WHERE cart_id = ? AND product_id = ?");
        $stmt->execute([$quantity, $product['price'], $cartId, $productId]);
    }

    public static function removeItem(int $cartId, int $productId): void {
        $stmt = self::db()->prepare("DELETE FROM cart_items WHERE cart_id = ? AND product_id = ?");
        $stmt->execute([$cartId, $productId]);
    }

    public static function clear(int $cartId): void {
        $stmt = self::db()->prepare("DELETE FROM cart_items WHERE cart_id = ?");
        $stmt->execute([$cartId]);
        self::update($cartId, ['coupon_code' => null]);
    }

    public static function getTotals(int $cartId): array {
        $items = self::getItems($cartId);
        $subtotal = 0.0;
        $itemCount = 0;

        foreach ($items as $item) {
            $subtotal += ((float)$item['unit_price'] * (int)$item['quantity']);
            $itemCount += (int)$item['quantity'];
        }

        $cart = self::find($cartId);
        $couponCode = $cart['coupon_code'] ?? null;
        $discount = 0.0;
        $coupon = null;

        if ($couponCode && $subtotal > 0) {
            $coupon = Coupon::findValid($couponCode, $subtotal);
            if ($coupon) {
                $discount = Coupon::calculateDiscount($coupon, $subtotal);
            } else {
                // Invalidated
                self::update($cartId, ['coupon_code' => null]);
                $couponCode = null;
            }
        }

        $freeThreshold = (float)Setting::get('free_shipping_threshold', '0');
        $shippingFee = (float)Setting::get('standard_shipping_fee', '0');
        $shipping = ($subtotal >= $freeThreshold || $subtotal == 0) ? 0.0 : $shippingFee;

        $total = max(0.0, ($subtotal - $discount) + $shipping);

        return [
            'items' => $items,
            'item_count' => $itemCount,
            'subtotal' => $subtotal,
            'discount' => $discount,
            'coupon_code' => $couponCode,
            'shipping' => $shipping,
            'total' => $total,
        ];
    }
}
