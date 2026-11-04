<?php
namespace App\Controllers\Admin;

use App\Models\Category;
use App\Helpers\View;
use App\Helpers\Csrf;
use App\Helpers\Session;
use App\Middleware\AdminMiddleware;
use App\Config\App;

class CategoryController {
    public static function index(): void {
        AdminMiddleware::check();
        $categories = Category::all('sort_order ASC, id ASC');

        View::render('admin/categories/index', [
            'breadcrumb' => 'Categories',
            'title' => 'Categories Management',
            'categories' => $categories
        ], 'admin');
    }

    public static function store(): void {
        AdminMiddleware::check();
        if (!Csrf::verify($_POST['csrf_token'] ?? '')) die("Security error.");

        $name = trim($_POST['name'] ?? '');
        $slug = trim($_POST['slug'] ?? '') ?: strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name), '-'));

        Category::insert([
            'name' => $name,
            'slug' => $slug,
            'description' => trim($_POST['description'] ?? ''),
            'is_active' => 1
        ]);

        Session::setFlash('admin_success', 'Category added.');
        header('Location: ' . App::baseUrl('admin/categories'));
        exit;
    }
}
