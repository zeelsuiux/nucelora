<?php
namespace App\Controllers;

use App\Models\Order;
use App\Helpers\View;
use App\Helpers\Auth;
use App\Middleware\AuthMiddleware;

class AccountController {
    public static function index(): void {
        AuthMiddleware::check();
        $user = Auth::user();
        $orders = Order::getByCustomer($user['id']);

        View::render('account/index', [
            'meta_title' => 'My Account — Nucelora Skincare',
            'customer' => $user,
            'orders' => $orders
        ]);
    }

    public static function orderDetail(int $orderId): void {
        AuthMiddleware::check();
        $user = Auth::user();
        $order = Order::getWithDetails($orderId);

        if (!$order || $order['customer_id'] != $user['id']) {
            http_response_code(404);
            die("Order not found or permission denied.");
        }

        View::render('account/order_detail', [
            'meta_title' => 'Order ' . $order['order_number'] . ' — Nucelora Skincare',
            'order' => $order
        ]);
    }
}
