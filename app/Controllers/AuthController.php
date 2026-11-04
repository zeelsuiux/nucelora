<?php
namespace App\Controllers;

use App\Models\Customer;
use App\Helpers\View;
use App\Helpers\Auth;
use App\Helpers\Csrf;
use App\Helpers\Session;
use App\Helpers\RateLimiter;
use App\Config\App;

class AuthController {
    public static function login(): void {
        if (Auth::check()) {
            header('Location: ' . App::baseUrl('account'));
            exit;
        }

        View::render('auth/login', [
            'meta_title' => 'Sign In to Your Account — Nucelora Skincare'
        ]);
    }

    public static function loginSubmit(): void {
        Session::start();
        if (!Csrf::verify($_POST['csrf_token'] ?? '')) {
            die("Security token expired.");
        }

        if (RateLimiter::tooManyAttempts('customer_login', 5, 900)) {
            $seconds = RateLimiter::availableIn('customer_login');
            $mins = ceil($seconds / 60);
            Session::setFlash('login_error', "Too many failed attempts. Please try again in {$mins} minutes.");
            header('Location: ' . App::baseUrl('account/login'));
            exit;
        }

        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        $customer = Customer::findByEmail($email);
        if ($customer && password_verify($password, $customer['password_hash'])) {
            RateLimiter::clear('customer_login');
            Auth::login($customer);
            header('Location: ' . App::baseUrl('account'));
            exit;
        }

        RateLimiter::hit('customer_login', 900);
        Session::setFlash('login_error', 'Invalid email address or password. Please try again.');
        header('Location: ' . App::baseUrl('account/login'));
        exit;
    }

    public static function register(): void {
        if (Auth::check()) {
            header('Location: ' . App::baseUrl('account'));
            exit;
        }

        View::render('auth/register', [
            'meta_title' => 'Create an Account — Nucelora Skincare'
        ]);
    }

    public static function registerSubmit(): void {
        Session::start();
        if (!Csrf::verify($_POST['csrf_token'] ?? '')) {
            die("Security token expired.");
        }

        $firstName = trim($_POST['first_name'] ?? '');
        $lastName = trim($_POST['last_name'] ?? '');
        $email = trim(strtolower($_POST['email'] ?? ''));
        $phone = trim($_POST['phone'] ?? '');
        $password = $_POST['password'] ?? '';

        if (!$firstName || !$email || strlen($password) < 6) {
            Session::setFlash('register_error', 'Please fill all required fields (password min 6 chars).');
            header('Location: ' . App::baseUrl('account/register'));
            exit;
        }

        if (Customer::findByEmail($email)) {
            Session::setFlash('register_error', 'An account with this email address already exists.');
            header('Location: ' . App::baseUrl('account/register'));
            exit;
        }

        $id = Customer::insert([
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $email,
            'phone' => $phone,
            'password_hash' => password_hash($password, PASSWORD_BCRYPT),
            'status' => 'active'
        ]);

        $newCustomer = Customer::find($id);
        Auth::login($newCustomer);

        header('Location: ' . App::baseUrl('account'));
        exit;
    }

    public static function logout(): void {
        Auth::logout();
        header('Location: ' . App::baseUrl());
        exit;
    }

    public static function recover(): void {
        if (Auth::check()) {
            header('Location: ' . App::baseUrl('account'));
            exit;
        }

        View::render('auth/recover', [
            'meta_title' => 'Reset Your Password — Nucelora Skincare'
        ]);
    }

    public static function recoverSubmit(): void {
        Session::start();
        if (!Csrf::verify($_POST['csrf_token'] ?? '')) {
            die("Security token expired.");
        }

        $email = trim(strtolower($_POST['email'] ?? ''));
        if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            Session::setFlash('recover_error', 'Please provide a valid email address.');
            header('Location: ' . App::baseUrl('account/recover'));
            exit;
        }

        $customer = Customer::findByEmail($email);
        if (!$customer) {
            // Security best practice: don't reveal if email exists, or provide friendly note
            Session::setFlash('recover_success', 'If an account exists with this email, a password reset link has been generated.');
            header('Location: ' . App::baseUrl('account/recover'));
            exit;
        }

        // Generate secure 64-char token
        $token = bin2hex(random_bytes(32));
        $expiresAt = date('Y-m-d H:i:s', strtotime('+1 hour'));

        $db = \App\Config\Database::connect();
        // Remove any old tokens for this email
        $del = $db->prepare("DELETE FROM password_reset_tokens WHERE email = ?");
        $del->execute([$email]);

        // Insert new token
        $ins = $db->prepare("INSERT INTO password_reset_tokens (email, token, expires_at) VALUES (?, ?, ?)");
        $ins->execute([$email, $token, $expiresAt]);

        $resetUrl = App::baseUrl('account/reset-password?token=' . $token);

        // Send password reset email
        @mail($email, "Password Reset — Nucelora Skincare", "Click the link to reset your password: " . $resetUrl);

        Session::setFlash('recover_success', 'If an account exists with this email address, password reset instructions have been sent to your email.');
        header('Location: ' . App::baseUrl('account/recover'));
        exit;
    }

    public static function resetPassword(): void {
        $token = trim($_GET['token'] ?? '');
        if (!$token) {
            header('Location: ' . App::baseUrl('account/recover'));
            exit;
        }

        $db = \App\Config\Database::connect();
        $stmt = $db->prepare("SELECT * FROM password_reset_tokens WHERE token = ? AND expires_at > NOW() LIMIT 1");
        $stmt->execute([$token]);
        $resetRecord = $stmt->fetch();

        if (!$resetRecord) {
            Session::start();
            Session::setFlash('recover_error', 'This password reset link is invalid or has expired. Please request a new one.');
            header('Location: ' . App::baseUrl('account/recover'));
            exit;
        }

        View::render('auth/reset-password', [
            'meta_title' => 'Set New Password — Nucelora Skincare',
            'token' => $token,
            'email' => $resetRecord['email']
        ]);
    }

    public static function resetPasswordSubmit(): void {
        Session::start();
        if (!Csrf::verify($_POST['csrf_token'] ?? '')) {
            die("Security token expired.");
        }

        $token = trim($_POST['token'] ?? '');
        $password = $_POST['password'] ?? '';
        $confirmPassword = $_POST['password_confirm'] ?? '';

        if (strlen($password) < 6) {
            Session::setFlash('reset_error', 'Password must be at least 6 characters long.');
            header('Location: ' . App::baseUrl('account/reset-password?token=' . urlencode($token)));
            exit;
        }

        if ($password !== $confirmPassword) {
            Session::setFlash('reset_error', 'Passwords do not match. Please re-enter.');
            header('Location: ' . App::baseUrl('account/reset-password?token=' . urlencode($token)));
            exit;
        }

        $db = \App\Config\Database::connect();
        $stmt = $db->prepare("SELECT * FROM password_reset_tokens WHERE token = ? AND expires_at > NOW() LIMIT 1");
        $stmt->execute([$token]);
        $resetRecord = $stmt->fetch();

        if (!$resetRecord) {
            Session::setFlash('recover_error', 'Your reset session expired. Please try again.');
            header('Location: ' . App::baseUrl('account/recover'));
            exit;
        }

        $email = $resetRecord['email'];
        $customer = Customer::findByEmail($email);

        if (!$customer) {
            Session::setFlash('recover_error', 'Customer account not found.');
            header('Location: ' . App::baseUrl('account/recover'));
            exit;
        }

        // Update password
        $upd = $db->prepare("UPDATE customers SET password_hash = ? WHERE id = ?");
        $upd->execute([password_hash($password, PASSWORD_BCRYPT), $customer['id']]);

        // Clean up tokens
        $db->prepare("DELETE FROM password_reset_tokens WHERE email = ?")->execute([$email]);

        // Log user in automatically
        $refreshedCustomer = Customer::find($customer['id']);
        Auth::login($refreshedCustomer);

        Session::setFlash('account_success', 'Your password was successfully updated!');
        header('Location: ' . App::baseUrl('account'));
        exit;
    }
}
