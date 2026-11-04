<?php
namespace App\Controllers\Admin;

use App\Models\Coupon;
use App\Helpers\View;
use App\Helpers\Csrf;
use App\Helpers\Session;
use App\Middleware\AdminMiddleware;
use App\Config\App;

class CouponController {
    public static function index(): void {
        AdminMiddleware::check();
        $coupons = Coupon::all('id DESC');

        View::render('admin/coupons/index', [
            'breadcrumb' => 'Discount Coupons',
            'title' => 'Coupon Management',
            'coupons' => $coupons
        ], 'admin');
    }

    public static function store(): void {
        AdminMiddleware::check();
        if (!Csrf::verify($_POST['csrf_token'] ?? '')) die("Security error.");

        $code = strtoupper(trim($_POST['code'] ?? ''));
        Coupon::insert([
            'code' => $code,
            'discount_type' => $_POST['discount_type'] ?? 'percentage',
            'discount_value' => (float)($_POST['discount_value'] ?? 10),
            'min_order_amount' => (float)($_POST['min_order_amount'] ?? 0),
            'is_active' => 1
        ]);

        Session::setFlash('admin_success', "Coupon {$code} added.");
        header('Location: ' . App::baseUrl('admin/coupons'));
        exit;
    }

    public static function delete(): void {
        AdminMiddleware::check();
        if (!Csrf::verify($_REQUEST['csrf_token'] ?? '')) {
            die("Security error: Invalid or missing CSRF token.");
        }
        $id = (int)($_REQUEST['id'] ?? 0);
        Coupon::delete($id);
        Session::setFlash('admin_success', 'Coupon deleted.');
        header('Location: ' . App::baseUrl('admin/coupons'));
        exit;
    }
}
