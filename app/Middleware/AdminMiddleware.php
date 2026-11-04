<?php
namespace App\Middleware;

use App\Helpers\Auth;
use App\Config\App;

class AdminMiddleware {
    public static function check(): void {
        if (!Auth::checkAdmin()) {
            header('Location: ' . App::baseUrl('admin/login'));
            exit;
        }
    }
}
