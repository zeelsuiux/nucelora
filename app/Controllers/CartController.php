<?php
namespace App\Controllers;

use App\Models\Cart;
use App\Models\Coupon;
use App\Helpers\View;
use App\Helpers\Session;
use App\Helpers\Csrf;
use App\Config\App;

class CartController {
    public static function index(): void {
        Session::start();
        $cart = Cart::getOrCreate();
        $totals = Cart::getTotals($cart['id']);

        View::render('cart/index', [
            'meta_title' => 'Your Shopping Bag — Nucelora Skincare',
            'totals' => $totals,
            'cart' => $cart
        ]);
    }

    public static function json(): void {
        Session::start();
        $cart = Cart::getOrCreate();
        $totals = Cart::getTotals($cart['id']);

        $itemsFormatted = [];
        foreach ($totals['items'] as $it) {
            $itemsFormatted[] = [
                'id' => (int)$it['product_id'],
                'variant_id' => (int)$it['product_id'],
                'quantity' => (int)$it['quantity'],
                'title' => $it['title'],
                'product_title' => $it['title'],
                'price' => (int)((float)$it['unit_price'] * 100),
                'original_price' => (int)((float)($it['compare_at_price'] ?: $it['unit_price']) * 100),
                'line_price' => (int)(((float)$it['unit_price'] * (int)$it['quantity']) * 100),
                'image' => $it['image_url'] ?? '',
                'featured_image' => ['url' => $it['image_url'] ?? ''],
                'url' => App::baseUrl('products/' . $it['slug']),
                'size' => $it['size_volume'] ?? ''
            ];
        }

        View::json([
            'token' => $cart['session_token'],
            'item_count' => $totals['item_count'],
            'total_price' => (int)($totals['total'] * 100),
            'original_total_price' => (int)($totals['subtotal'] * 100),
            'total_discount' => (int)($totals['discount'] * 100),
            'items' => $itemsFormatted
        ]);
    }

    public static function add(): void {
        Session::start();
        $cart = Cart::getOrCreate();

        $raw = file_get_contents('php://input');
        $payload = json_decode($raw, true) ?: $_POST;

        $items = $payload['items'] ?? [];
        if (empty($items) && !empty($payload['id'])) {
            $items = [['id' => $payload['id'], 'quantity' => $payload['quantity'] ?? 1]];
        }

        foreach ($items as $item) {
            $productId = (int)($item['id'] ?? 0);
            $qty = max(1, (int)($item['quantity'] ?? 1));
            if ($productId > 0) {
                Cart::addItem($cart['id'], $productId, null, $qty);
            }
        }

        self::json();
    }

    public static function change(): void {
        Session::start();
        $cart = Cart::getOrCreate();

        $raw = file_get_contents('php://input');
        $payload = json_decode($raw, true) ?: $_POST;

        $productId = (int)($payload['id'] ?? 0);
        $qty = (int)($payload['quantity'] ?? 0);

        // If line number passed instead of id, map to item
        if ($productId === 0 && !empty($payload['line'])) {
            $lineIndex = (int)$payload['line'] - 1;
            $totals = Cart::getTotals($cart['id']);
            if (isset($totals['items'][$lineIndex])) {
                $productId = (int)$totals['items'][$lineIndex]['product_id'];
            }
        }

        if ($productId > 0) {
            Cart::updateQuantity($cart['id'], $productId, $qty);
        }

        self::json();
    }

    public static function applyCoupon(): void {
        Session::start();
        $cart = Cart::getOrCreate();
        $code = trim($_POST['coupon_code'] ?? '');

        if ($code !== '') {
            $totals = Cart::getTotals($cart['id']);
            $valid = Coupon::findValid($code, $totals['subtotal']);
            if ($valid) {
                Cart::update($cart['id'], ['coupon_code' => $code]);
                Session::setFlash('cart_success', "Coupon {$code} applied successfully!");
            } else {
                Session::setFlash('cart_error', "Coupon code is invalid or does not meet minimum order requirements.");
            }
        }

        header('Location: ' . App::baseUrl('cart'));
        exit;
    }
}
