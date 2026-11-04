<?php
namespace App\Controllers\Admin;

use App\Models\Product;
use App\Models\Category;
use App\Helpers\View;
use App\Helpers\Csrf;
use App\Helpers\Session;
use App\Middleware\AdminMiddleware;
use App\Config\App;
use App\Config\Database;

class ProductController {
    public static function index(): void {
        AdminMiddleware::check();
        $products = Product::getAllWithImages('1=1', [], 'p.id DESC', 200);

        View::render('admin/products/index', [
            'breadcrumb' => 'Products Management',
            'title' => 'Product Catalog',
            'products' => $products
        ], 'admin');
    }

    public static function create(): void {
        AdminMiddleware::check();
        $categories = Category::all('name ASC');

        View::render('admin/products/form', [
            'breadcrumb' => 'Add New Product',
            'title' => 'Create Product',
            'categories' => $categories,
            'product' => null
        ], 'admin');
    }

    public static function store(): void {
        AdminMiddleware::check();
        if (!Csrf::verify($_POST['csrf_token'] ?? '')) die("Security token error.");

        $title = trim($_POST['title'] ?? '');
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title), '-'));
        $sku = trim($_POST['sku'] ?? ('LYM-' . rand(1000, 9999)));

        $id = Product::insert([
            'category_id' => !empty($_POST['category_id']) ? (int)$_POST['category_id'] : null,
            'title' => $title,
            'slug' => $slug,
            'sku' => $sku,
            'short_description' => trim($_POST['short_description'] ?? ''),
            'description' => trim($_POST['description'] ?? ''),
            'benefits' => trim($_POST['benefits'] ?? ''),
            'directions' => trim($_POST['directions'] ?? ''),
            'size_volume' => trim($_POST['size_volume'] ?? '30 ml'),
            'price' => (float)($_POST['price'] ?? 0),
            'compare_at_price' => !empty($_POST['compare_at_price']) ? (float)$_POST['compare_at_price'] : null,
            'stock_quantity' => (int)($_POST['stock_quantity'] ?? 100),
            'badge_text' => trim($_POST['badge_text'] ?? ''),
            'is_featured' => !empty($_POST['is_featured']) ? 1 : 0,
            'is_best_seller' => !empty($_POST['is_best_seller']) ? 1 : 0,
            'is_active' => !empty($_POST['is_active']) ? 1 : 0,
        ]);

        if (!empty($_POST['image_url'])) {
            Database::connect()->prepare("INSERT INTO product_images (product_id, image_url, alt_text, sort_order, is_primary) VALUES (?, ?, ?, 1, 1)")
                     ->execute([$id, trim($_POST['image_url']), $title]);
        }

        Session::setFlash('admin_success', 'Product created successfully.');
        header('Location: ' . App::baseUrl('admin/products'));
        exit;
    }

    public static function edit(): void {
        AdminMiddleware::check();
        $id = (int)($_GET['id'] ?? 0);
        $product = Product::find($id);
        if (!$product) die("Product not found");

        $images = Product::getImages($id);
        $product['image_url'] = $images[0]['image_url'] ?? '';
        $categories = Category::all('name ASC');

        View::render('admin/products/form', [
            'breadcrumb' => 'Edit Product',
            'title' => 'Edit ' . $product['title'],
            'categories' => $categories,
            'product' => $product
        ], 'admin');
    }

    public static function update(): void {
        AdminMiddleware::check();
        if (!Csrf::verify($_POST['csrf_token'] ?? '')) die("Security token error.");

        $id = (int)($_POST['id'] ?? 0);
        $title = trim($_POST['title'] ?? '');

        Product::update($id, [
            'category_id' => !empty($_POST['category_id']) ? (int)$_POST['category_id'] : null,
            'title' => $title,
            'sku' => trim($_POST['sku'] ?? ''),
            'short_description' => trim($_POST['short_description'] ?? ''),
            'description' => trim($_POST['description'] ?? ''),
            'benefits' => trim($_POST['benefits'] ?? ''),
            'directions' => trim($_POST['directions'] ?? ''),
            'size_volume' => trim($_POST['size_volume'] ?? '30 ml'),
            'price' => (float)($_POST['price'] ?? 0),
            'compare_at_price' => !empty($_POST['compare_at_price']) ? (float)$_POST['compare_at_price'] : null,
            'stock_quantity' => (int)($_POST['stock_quantity'] ?? 0),
            'badge_text' => trim($_POST['badge_text'] ?? ''),
            'is_featured' => !empty($_POST['is_featured']) ? 1 : 0,
            'is_best_seller' => !empty($_POST['is_best_seller']) ? 1 : 0,
            'is_active' => !empty($_POST['is_active']) ? 1 : 0,
        ]);

        if (!empty($_POST['image_url'])) {
            $db = Database::connect();
            $stmt = $db->prepare("UPDATE product_images SET image_url = ? WHERE product_id = ? AND is_primary = 1");
            $stmt->execute([trim($_POST['image_url']), $id]);
            if ($stmt->rowCount() === 0) {
                $db->prepare("INSERT INTO product_images (product_id, image_url, alt_text, sort_order, is_primary) VALUES (?, ?, ?, 1, 1)")
                   ->execute([$id, trim($_POST['image_url']), $title]);
            }
        }

        Session::setFlash('admin_success', 'Product updated successfully.');
        header('Location: ' . App::baseUrl('admin/products'));
        exit;
    }

    public static function delete(): void {
        AdminMiddleware::check();
        if (!Csrf::verify($_REQUEST['csrf_token'] ?? '')) {
            die("Security error: Invalid or missing CSRF token.");
        }
        $id = (int)($_REQUEST['id'] ?? 0);
        Product::delete($id);
        Session::setFlash('admin_success', 'Product deleted.');
        header('Location: ' . App::baseUrl('admin/products'));
        exit;
    }
}
