<?php
namespace App\Controllers\Admin;

use App\Models\Customer;
use App\Helpers\View;
use App\Middleware\AdminMiddleware;
use App\Config\Database;

class CustomerController {
    public static function index(): void {
        AdminMiddleware::check();

        $sql = "SELECT c.*, COUNT(o.id) as order_count 
                FROM customers c 
                LEFT JOIN orders o ON o.customer_id = c.id 
                GROUP BY c.id 
                ORDER BY c.id DESC";
        $customers = Database::connect()->query($sql)->fetchAll();

        View::render('admin/customers/index', [
            'breadcrumb' => 'Customers',
            'title' => 'Customer Profiles',
            'customers' => $customers
        ], 'admin');
    }
}
