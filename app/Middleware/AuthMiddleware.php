<?php
namespace App\Middleware;

use App\Helpers\Auth;
use App\Config\App;

class AuthMiddleware {
    public static function check(): void {
        if (!Auth::check()) {
            header('Location: ' . App::baseUrl('account/login'));
            exit;
        }
    }
}
