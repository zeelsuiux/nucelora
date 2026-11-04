<?php
namespace App\Controllers\Admin;

use App\Models\Review;
use App\Helpers\View;
use App\Helpers\Session;
use App\Middleware\AdminMiddleware;
use App\Config\App;
use App\Config\Database;

class ReviewController {
    public static function index(): void {
        AdminMiddleware::check();

        $sql = "SELECT r.*, p.title as product_title 
                FROM product_reviews r 
                LEFT JOIN products p ON p.id = r.product_id 
                ORDER BY r.id DESC";
        $reviews = Database::connect()->query($sql)->fetchAll();

        View::render('admin/reviews/index', [
            'breadcrumb' => 'Reviews',
            'title' => 'Customer Reviews Moderation',
            'reviews' => $reviews
        ], 'admin');
    }

    public static function approve(): void {
        AdminMiddleware::check();
        if (!Csrf::verify($_REQUEST['csrf_token'] ?? '')) {
            die("Security error: Invalid or missing CSRF token.");
        }
        $id = (int)($_REQUEST['id'] ?? 0);
        Review::update($id, ['is_approved' => 1]);
        Session::setFlash('admin_success', 'Review approved.');
        header('Location: ' . App::baseUrl('admin/reviews'));
        exit;
    }

    public static function reject(): void {
        AdminMiddleware::check();
        if (!Csrf::verify($_REQUEST['csrf_token'] ?? '')) {
            die("Security error: Invalid or missing CSRF token.");
        }
        $id = (int)($_REQUEST['id'] ?? 0);
        Review::update($id, ['is_approved' => 0]);
        Session::setFlash('admin_success', 'Review hidden.');
        header('Location: ' . App::baseUrl('admin/reviews'));
        exit;
    }

    public static function delete(): void {
        AdminMiddleware::check();
        if (!Csrf::verify($_REQUEST['csrf_token'] ?? '')) {
            die("Security error: Invalid or missing CSRF token.");
        }
        $id = (int)($_REQUEST['id'] ?? 0);
        Review::delete($id);
        Session::setFlash('admin_success', 'Review removed.');
        header('Location: ' . App::baseUrl('admin/reviews'));
        exit;
    }
}
