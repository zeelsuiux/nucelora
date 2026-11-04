<?php
namespace App\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Customer;
use App\Helpers\View;
use App\Helpers\Session;
use App\Helpers\Auth;
use App\Helpers\Csrf;
use App\Config\App;
use App\Services\RazorpayService;
use Exception;

class CheckoutController {
    public static function index(): void {
        Session::start();
        $cart = Cart::getOrCreate();
        $totals = Cart::getTotals($cart['id']);
        $featured = \App\Models\Product::getBestSellers(4);

        View::render('checkout/index', [
            'meta_title' => 'Secure Checkout — Nucelora Skincare',
            'totals' => $totals,
            'cart' => $cart,
            'featured' => $featured
        ], 'main');
    }

    public static function process(): void {
        Session::start();
        if (!Csrf::verify($_POST['csrf_token'] ?? '')) {
            die("Security check failed. Please refresh and try again.");
        }

        $cart = Cart::getOrCreate();
        $totals = Cart::getTotals($cart['id']);

        if ($totals['item_count'] === 0) {
            header('Location: ' . App::baseUrl('cart'));
            exit;
        }

        $paymentMethod = $_POST['payment_method'] ?? 'cod';
        $email = trim($_POST['email'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $fullName = trim($_POST['full_name'] ?? '');

        if (!$email || !$phone || !$fullName) {
            die("Please fill out all required contact and shipping details.");
        }

        $shippingAddress = [
            'full_name' => $fullName,
            'phone' => $phone,
            'address_line1' => trim($_POST['address_line1'] ?? ''),
            'address_line2' => trim($_POST['address_line2'] ?? ''),
            'city' => trim($_POST['city'] ?? ''),
            'state' => trim($_POST['state'] ?? ''),
            'postal_code' => trim($_POST['postal_code'] ?? ''),
            'country' => 'India'
        ];

        // Customer context
        $customer = Auth::user();
        if (!$customer && $email) {
            $existing = Customer::findByEmail($email);
            if ($existing) {
                $customer = $existing;
            }
        }

        $customerData = [
            'id' => $customer['id'] ?? null,
            'email' => $email,
            'phone' => $phone,
            'name' => $fullName
        ];

        try {
            $order = Order::createOrder($totals, $customerData, $shippingAddress, $paymentMethod);

            // If payment was via Razorpay, strictly verify signature
            if ($paymentMethod === 'razorpay') {
                $razorpayPaymentId = trim($_POST['razorpay_payment_id'] ?? '');
                $razorpayOrderId = trim($_POST['razorpay_order_id'] ?? '');
                $razorpaySignature = trim($_POST['razorpay_signature'] ?? '');

                if (empty($razorpayPaymentId) || empty($razorpaySignature)) {
                    die("Payment verification failed: Incomplete payment parameters.");
                }

                $isValid = RazorpayService::verifySignature($razorpayOrderId, $razorpayPaymentId, $razorpaySignature);
                if (!$isValid) {
                    die("Payment signature verification failed. Transaction was not confirmed.");
                }

                Order::updatePayment($order['id'], 'paid', $razorpayPaymentId, json_encode([
                    'payment_id' => $razorpayPaymentId,
                    'order_id' => $razorpayOrderId,
                    'signature' => $razorpaySignature
                ]));
                Order::updateStatus($order['id'], 'confirmed', 'Online payment verified and confirmed via Razorpay ID: ' . $razorpayPaymentId);
            }

            // Save order ID in session for IDOR-safe access
            Session::set('last_placed_order_id', (int)$order['id']);

            // Clear Cart
            Cart::clear($cart['id']);

            // Redirect to success
            header('Location: ' . App::baseUrl('checkout/success?order_id=' . $order['id']));
            exit;
        } catch (Exception $e) {
            die("Order creation error: " . htmlspecialchars($e->getMessage()));
        }
    }

    public static function success(): void {
        Session::start();
        $orderId = (int)($_GET['order_id'] ?? 0);
        $lastPlacedOrderId = (int)Session::get('last_placed_order_id');
        $loggedInCustomerId = Auth::id();

        $order = Order::getWithDetails($orderId);

        if (!$order) {
            header('Location: ' . App::baseUrl());
            exit;
        }

        // Authorization check: User must have placed this order in the current session or be the logged-in owner
        $isOwner = false;
        if ($lastPlacedOrderId > 0 && $lastPlacedOrderId === $orderId) {
            $isOwner = true;
        } elseif ($loggedInCustomerId && !empty($order['customer_id']) && (int)$order['customer_id'] === (int)$loggedInCustomerId) {
            $isOwner = true;
        }

        if (!$isOwner) {
            http_response_code(403);
            die("Access denied: You do not have permission to view this order confirmation.");
        }

        $address = json_decode($order['shipping_address_json'] ?? '[]', true) ?: [];
        $email = trim(strtolower($order['guest_email'] ?? ''));
        
        // If customer is already logged in, or order already has customer_id, or email already registered in customers table
        $existingCustomer = $email ? Customer::findByEmail($email) : null;
        $canCreateAccount = empty($order['customer_id']) && !$existingCustomer && !Auth::check() && !empty($email);

        View::render('checkout/success', [
            'meta_title' => 'Order Confirmed — ' . $order['order_number'],
            'order' => $order,
            'canCreateAccount' => $canCreateAccount,
            'email' => $email,
            'customerName' => $address['full_name'] ?? 'Customer'
        ]);
    }

    public static function createAccount(): void {
        Session::start();
        header('Content-Type: application/json');

        if (!Csrf::verify($_POST['csrf_token'] ?? '')) {
            echo json_encode(['success' => false, 'message' => 'Security token expired. Please refresh the page.']);
            exit;
        }

        $orderId = (int)($_POST['order_id'] ?? 0);
        $lastPlacedOrderId = (int)Session::get('last_placed_order_id');

        if ($orderId <= 0 || $lastPlacedOrderId !== $orderId) {
            echo json_encode(['success' => false, 'message' => 'Unauthorized: Invalid order session.']);
            exit;
        }

        $password = $_POST['password'] ?? '';

        if (strlen($password) < 6) {
            echo json_encode(['success' => false, 'message' => 'Password must be at least 6 characters long.']);
            exit;
        }

        $order = Order::find($orderId);
        if (!$order) {
            echo json_encode(['success' => false, 'message' => 'Order not found.']);
            exit;
        }

        $email = trim(strtolower($order['guest_email'] ?? ''));
        if (!$email) {
            echo json_encode(['success' => false, 'message' => 'No email address found for this order.']);
            exit;
        }

        // Double check: if email already exists, do not recreate
        $existing = Customer::findByEmail($email);
        if ($existing) {
            echo json_encode(['success' => false, 'message' => 'An account with this email already exists. You can sign in directly.']);
            exit;
        }

        $address = json_decode($order['shipping_address_json'] ?? '[]', true) ?: [];
        $fullName = trim($address['full_name'] ?? '');
        $parts = explode(' ', $fullName, 2);
        $firstName = $parts[0] ?: 'Customer';
        $lastName = $parts[1] ?? '';
        $phone = $address['phone'] ?? '';

        // Create new customer account
        $customerId = Customer::insert([
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $email,
            'phone' => $phone,
            'password_hash' => password_hash($password, PASSWORD_BCRYPT),
            'status' => 'active'
        ]);

        // Link this order and any previous guest orders with this email to the new account
        $db = \App\Config\Database::connect();
        $stmt = $db->prepare("UPDATE orders SET customer_id = ? WHERE guest_email = ? OR id = ?");
        $stmt->execute([$customerId, $email, $orderId]);

        // Automatically log customer in
        $newCustomer = Customer::find($customerId);
        Auth::login($newCustomer);

        echo json_encode([
            'success' => true,
            'message' => 'Your account has been created! You can now track your order anytime.',
            'redirect' => App::baseUrl('account')
        ]);
        exit;
    }
}
