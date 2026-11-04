<?php
namespace App\Controllers\Admin;

use App\Models\Order;
use App\Models\Product;
use App\Helpers\View;
use App\Middleware\AdminMiddleware;

class DashboardController {
    public static function index(): void {
        AdminMiddleware::check();

        $kpis = Order::getKpis();
        $recentOrders = Order::all('id DESC LIMIT 8');
        $lowStockList = Product::where('stock_quantity', 10, '<=');

        View::render('admin/dashboard', [
            'breadcrumb' => 'Dashboard',
            'title' => 'Store Overview',
            'kpis' => $kpis,
            'recentOrders' => $recentOrders,
            'lowStockList' => $lowStockList
        ], 'admin');
    }
}
