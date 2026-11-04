<?php
namespace App\Controllers\Admin;

use App\Config\Database;
use App\Config\App;
use App\Helpers\View;
use App\Helpers\Auth;
use App\Helpers\Csrf;
use App\Helpers\Session;
use App\Helpers\RateLimiter;

class AuthController {
    public static function login(): void {
        if (Auth::checkAdmin()) {
            header('Location: ' . App::baseUrl('admin'));
            exit;
        }

        View::render('admin/login', [
            'title' => 'Admin Sign In'
        ], 'none');
    }

    public static function loginSubmit(): void {
        Session::start();
        if (!Csrf::verify($_POST['csrf_token'] ?? '')) {
            die("Security token expired.");
        }

        if (RateLimiter::tooManyAttempts('admin_login', 5, 900)) {
            $seconds = RateLimiter::availableIn('admin_login');
            $mins = ceil($seconds / 60);
            Session::setFlash('admin_login_error', "Too many failed login attempts. Please try again in {$mins} minutes.");
            header('Location: ' . App::baseUrl('admin/login'));
            exit;
        }

        $email = trim(strtolower($_POST['email'] ?? ''));
        $password = $_POST['password'] ?? '';

        $db = Database::connect();
        $stmt = $db->prepare("SELECT * FROM admins WHERE email = ? AND status = 'active' LIMIT 1");
        $stmt->execute([$email]);
        $admin = $stmt->fetch();

        if ($admin && password_verify($password, $admin['password_hash'])) {
            RateLimiter::clear('admin_login');
            Auth::loginAdmin($admin);
            $db->prepare("UPDATE admins SET last_login = NOW() WHERE id = ?")->execute([$admin['id']]);
            header('Location: ' . App::baseUrl('admin'));
            exit;
        }

        RateLimiter::hit('admin_login', 900);
        Session::setFlash('admin_login_error', 'Invalid admin email or password.');
        header('Location: ' . App::baseUrl('admin/login'));
        exit;
    }

    public static function logout(): void {
        Auth::logoutAdmin();
        header('Location: ' . App::baseUrl('admin/login'));
        exit;
    }
}
