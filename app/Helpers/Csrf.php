<?php
namespace App\Helpers;

class Csrf {
    public static function token(): string {
        Session::start();
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    public static function field(): string {
        $token = self::token();
        return '<input type="hidden" name="csrf_token" value="' . Esc::attr($token) . '">';
    }

    public static function verify(?string $token): bool {
        Session::start();
        $stored = $_SESSION['csrf_token'] ?? '';
        if (!$token || !$stored) return false;
        return hash_equals($stored, $token);
    }
}
