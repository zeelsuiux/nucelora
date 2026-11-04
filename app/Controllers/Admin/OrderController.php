<?php
namespace App\Controllers\Admin;

use App\Models\Order;
use App\Helpers\View;
use App\Helpers\Csrf;
use App\Helpers\Session;
use App\Helpers\Auth;
use App\Middleware\AdminMiddleware;
use App\Config\App;

class OrderController {
    public static function index(): void {
        AdminMiddleware::check();
        $orders = Order::all('id DESC LIMIT 100');

        View::render('admin/orders/index', [
            'breadcrumb' => 'Orders',
            'title' => 'Orders Management',
            'orders' => $orders
        ], 'admin');
    }

    public static function show(): void {
        AdminMiddleware::check();
        $id = (int)($_GET['id'] ?? 0);
        $order = Order::getWithDetails($id);
        if (!$order) die("Order not found");

        View::render('admin/orders/show', [
            'breadcrumb' => 'Order #' . $order['order_number'],
            'title' => 'Order Details',
            'order' => $order
        ], 'admin');
    }

    public static function updateStatus(): void {
        AdminMiddleware::check();
        if (!Csrf::verify($_POST['csrf_token'] ?? '')) die("Security error.");

        $orderId = (int)($_POST['order_id'] ?? 0);
        $status = $_POST['status'] ?? 'pending';
        $notes = trim($_POST['notes'] ?? '');

        Order::updateStatus($orderId, $status, $notes, Auth::adminId());

        Session::setFlash('admin_success', 'Order status updated to ' . strtoupper($status));
        header('Location: ' . App::baseUrl('admin/orders/show?id=' . $orderId));
        exit;
    }
}
