<?php
namespace App\Controllers;

use App\Models\CmsPage;
use App\Models\Product;
use App\Helpers\View;
use App\Helpers\Session;
use App\Helpers\Csrf;
use App\Config\Database;
use App\Config\App;

class PageController {
    public static function aboutUs(): void {
        View::render('pages/about-us', [
            'meta_title' => 'Our Philosophy & Story — Nucelora Skincare',
            'meta_description' => 'Discover Nucelora: Where Korean-inspired botanical intelligence meets clinical dermatological science crafted specifically for Indian skin types.'
        ]);
    }

    public static function routineFinder(): void {
        $catalog = Product::getAllWithImages('p.is_active = 1', [], 'p.id ASC', 27);

        View::render('pages/routine-finder', [
            'meta_title' => 'Personalized Skincare Routine Finder — Nucelora Skincare',
            'catalog' => $catalog
        ]);
    }

    public static function wishlist(): void {
        View::render('pages/wishlist', [
            'meta_title' => 'My Wishlist — Nucelora Skincare'
        ]);
    }

    public static function contact(): void {
        View::render('pages/contact', [
            'meta_title' => 'Contact Customer Care — Nucelora Skincare'
        ]);
    }

    public static function contactSubmit(): void {
        Session::start();
        if (!Csrf::verify($_POST['csrf_token'] ?? '')) {
            die("Security token invalid.");
        }

        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $subject = trim($_POST['subject'] ?? '');
        $message = trim($_POST['message'] ?? '');

        if ($name && $email && $message) {
            $db = Database::connect();
            $stmt = $db->prepare("INSERT INTO contact_messages (name, email, phone, subject, message) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$name, $email, $phone, $subject, $message]);

            Session::setFlash('contact_success', 'Thank you! Your message has been received. Our team will contact you within 24 hours.');
        }

        header('Location: ' . App::baseUrl('pages/contact'));
        exit;
    }

    public static function cms(string $slug): void {
        $page = CmsPage::findBySlug($slug);
        if (!$page) {
            http_response_code(404);
            die("Page not found");
        }

        View::render('pages/cms', [
            'meta_title' => ($page['meta_title'] ?: $page['title']) . ' — Nucelora Skincare',
            'meta_description' => $page['meta_description'] ?? '',
            'page' => $page
        ]);
    }
}
