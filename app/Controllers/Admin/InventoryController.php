<?php
namespace App\Controllers\Admin;

use App\Models\Product;
use App\Helpers\View;
use App\Helpers\Csrf;
use App\Helpers\Session;
use App\Middleware\AdminMiddleware;
use App\Config\App;

class InventoryController {
    public static function index(): void {
        AdminMiddleware::check();
        $products = Product::all('stock_quantity ASC');

        View::render('admin/inventory/index', [
            'breadcrumb' => 'Inventory',
            'title' => 'Stock Levels',
            'products' => $products
        ], 'admin');
    }

    public static function update(): void {
        AdminMiddleware::check();
        if (!Csrf::verify($_POST['csrf_token'] ?? '')) die("Security error.");

        $productId = (int)($_POST['product_id'] ?? 0);
        $qty = (int)($_POST['quantity'] ?? 0);

        Product::update($productId, ['stock_quantity' => $qty]);

        Session::setFlash('admin_success', 'Stock level adjusted.');
        header('Location: ' . App::baseUrl('admin/inventory'));
        exit;
    }
}
