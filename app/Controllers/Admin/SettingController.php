<?php
namespace App\Controllers\Admin;

use App\Models\Setting;
use App\Helpers\View;
use App\Helpers\Csrf;
use App\Helpers\Session;
use App\Middleware\AdminMiddleware;
use App\Config\App;
use App\Config\Database;

class SettingController {
    public static function index(): void {
        AdminMiddleware::check();

        $rows = Setting::all();
        $settings = [];
        foreach ($rows as $r) {
            $settings[$r['setting_key']] = $r['setting_value'];
        }

        View::render('admin/settings/index', [
            'breadcrumb' => 'Store Settings',
            'title' => 'Global Configuration',
            'settings' => $settings
        ], 'admin');
    }

    public static function update(): void {
        AdminMiddleware::check();
        if (!Csrf::verify($_POST['csrf_token'] ?? '')) die("Security error.");

        $fields = [
            'razorpay_key_id' => 'payment',
            'razorpay_key_secret' => 'payment',
            'free_shipping_threshold' => 'shipping',
            'standard_shipping_fee' => 'shipping',
            'contact_email' => 'contact',
            'contact_phone' => 'contact',
            'contact_address' => 'contact'
        ];

        foreach ($fields as $key => $group) {
            if (isset($_POST[$key])) {
                Setting::set($key, trim($_POST[$key]), $group);
            }
        }

        Session::setFlash('admin_success', 'Website settings updated successfully.');
        header('Location: ' . App::baseUrl('admin/settings'));
        exit;
    }
}
