<?php
namespace App\Helpers;

class Auth {
    // Customer Auth
    public static function check(): bool {
        Session::start();
        return !empty($_SESSION['customer_id']);
    }

    public static function user(): ?array {
        Session::start();
        return $_SESSION['customer'] ?? null;
    }

    public static function id(): ?int {
        Session::start();
        return $_SESSION['customer_id'] ?? null;
    }

    public static function login(array $customer): void {
        Session::start();
        session_regenerate_id(true);
        $_SESSION['customer_id'] = (int)$customer['id'];
        unset($customer['password_hash']);
        $_SESSION['customer'] = $customer;
    }

    public static function logout(): void {
        Session::start();
        unset($_SESSION['customer_id'], $_SESSION['customer']);
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_regenerate_id(true);
        }
    }

    // Admin Auth
    public static function checkAdmin(): bool {
        Session::start();
        return !empty($_SESSION['admin_id']);
    }

    public static function admin(): ?array {
        Session::start();
        return $_SESSION['admin'] ?? null;
    }

    public static function adminId(): ?int {
        Session::start();
        return $_SESSION['admin_id'] ?? null;
    }

    public static function loginAdmin(array $admin): void {
        Session::start();
        session_regenerate_id(true);
        $_SESSION['admin_id'] = (int)$admin['id'];
        unset($admin['password_hash']);
        $_SESSION['admin'] = $admin;
    }

    public static function logoutAdmin(): void {
        Session::start();
        unset($_SESSION['admin_id'], $_SESSION['admin']);
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_regenerate_id(true);
        }
    }
}
