<?php
namespace App\Controllers\Admin;

use App\Models\Banner;
use App\Helpers\View;
use App\Helpers\Csrf;
use App\Helpers\Session;
use App\Middleware\AdminMiddleware;
use App\Config\App;

class BannerController {
    public static function index(): void {
        AdminMiddleware::check();
        $banners = Banner::all('sort_order ASC, id ASC');

        View::render('admin/banners/index', [
            'breadcrumb' => 'Homepage Banners',
            'title' => 'Spotlight Carousel',
            'banners' => $banners
        ], 'admin');
    }

    public static function store(): void {
        AdminMiddleware::check();
        if (!Csrf::verify($_POST['csrf_token'] ?? '')) die("Security error.");

        Banner::insert([
            'title' => trim($_POST['title'] ?? ''),
            'subtitle' => trim($_POST['subtitle'] ?? ''),
            'badge_text' => trim($_POST['badge_text'] ?? ''),
            'button_text' => trim($_POST['button_text'] ?? 'Shop Now'),
            'button_url' => trim($_POST['button_url'] ?? '/collections/all'),
            'desktop_image_url' => trim($_POST['desktop_image_url'] ?? ''),
            'bg_tint' => trim($_POST['bg_tint'] ?? '#f7f6f4'),
            'sort_order' => 1,
            'is_active' => 1
        ]);

        Session::setFlash('admin_success', 'Banner created.');
        header('Location: ' . App::baseUrl('admin/banners'));
        exit;
    }

    public static function delete(): void {
        AdminMiddleware::check();
        if (!Csrf::verify($_REQUEST['csrf_token'] ?? '')) {
            die("Security error: Invalid or missing CSRF token.");
        }
        $id = (int)($_REQUEST['id'] ?? 0);
        Banner::delete($id);
        Session::setFlash('admin_success', 'Banner deleted.');
        header('Location: ' . App::baseUrl('admin/banners'));
        exit;
    }
}
