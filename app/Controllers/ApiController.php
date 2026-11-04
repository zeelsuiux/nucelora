<?php
namespace App\Controllers;

use App\Models\Product;
use App\Helpers\View;
use App\Helpers\Csrf;
use App\Helpers\Format;
use App\Config\Database;
use App\Config\App;

class ApiController {
    public static function search(): void {
        $q = trim($_GET['q'] ?? '');
        if (strlen($q) < 2) {
            View::json(['resources' => ['results' => ['products' => []]]]);
            return;
        }

        $results = Product::search($q, 8);
        $formatted = [];
        foreach ($results as $p) {
            $formatted[] = [
                'id' => $p['id'],
                'title' => $p['title'],
                'price' => Format::money($p['price']),
                'compare_at_price' => !empty($p['compare_at_price']) ? Format::money($p['compare_at_price']) : '',
                'url' => App::baseUrl('products/' . $p['slug']),
                'image' => $p['image_url'] ?? App::asset('images/placeholder.jpg'),
                'size' => $p['size_volume'] ?? ''
            ];
        }

        View::json([
            'resources' => [
                'results' => [
                    'products' => $formatted
                ]
            ]
        ]);
    }

    private static function safeRedirect(): void {
        $referer = $_SERVER['HTTP_REFERER'] ?? '';
        if ($referer) {
            $refHost = parse_url($referer, PHP_URL_HOST);
            $currHost = $_SERVER['HTTP_HOST'] ?? '';
            $currHostOnly = explode(':', $currHost)[0];
            $refHostOnly = explode(':', (string)$refHost)[0];
            if ($refHostOnly !== '' && strcasecmp($refHostOnly, $currHostOnly) === 0) {
                header('Location: ' . filter_var($referer, FILTER_SANITIZE_URL));
                exit;
            }
        }
        header('Location: ' . App::baseUrl());
        exit;
    }

    public static function newsletter(): void {
        $email = trim(strtolower($_POST['email'] ?? ''));
        if ($email && filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $db = Database::connect();
            $stmt = $db->prepare("INSERT IGNORE INTO newsletters (email) VALUES (?)");
            $stmt->execute([$email]);
        }

        self::safeRedirect();
    }

    public static function review(): void {
        if (!Csrf::verify($_POST['csrf_token'] ?? '')) {
            die("Security check failed.");
        }

        $productId = (int)($_POST['product_id'] ?? 0);
        $name = trim($_POST['reviewer_name'] ?? '');
        $email = trim(strtolower($_POST['reviewer_email'] ?? ''));
        $rating = max(1, min(5, (int)($_POST['rating'] ?? 5)));
        $title = trim($_POST['title'] ?? '');
        $content = trim($_POST['content'] ?? '');

        if ($productId && $name && $email && $content && filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $db = Database::connect();

            // Verify if customer actually purchased this product
            $isVerified = 0;
            $chk = $db->prepare("SELECT COUNT(*) FROM orders o 
                                 JOIN order_items oi ON oi.order_id = o.id 
                                 WHERE (o.guest_email = ? OR o.customer_id IN (SELECT id FROM customers WHERE email = ?)) 
                                   AND oi.product_id = ? 
                                   AND o.status IN ('delivered', 'confirmed')");
            $chk->execute([$email, $email, $productId]);
            if ((int)$chk->fetchColumn() > 0) {
                $isVerified = 1;
            }

            // Requires admin moderation to prevent spam/defacement
            $isApproved = 0;

            $stmt = $db->prepare("INSERT INTO product_reviews (product_id, reviewer_name, reviewer_email, rating, title, content, is_verified_buyer, is_approved) 
                                 VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$productId, $name, $email, $rating, $title, $content, $isVerified, $isApproved]);
        }

        self::safeRedirect();
    }
}
