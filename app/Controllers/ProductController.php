<?php
namespace App\Controllers;

use App\Models\Product;
use App\Helpers\View;

class ProductController {
    public static function show(string $handle): void {
        $product = Product::findBySlug($handle);
        if (!$product) {
            http_response_code(404);
            die("Product not found");
        }

        if (($_GET['view'] ?? '') === 'card') {
            View::render('product/card', ['p' => $product], 'none');
            return;
        }

        $images = Product::getImages($product['id']);
        $reviews = Product::getReviews($product['id']);
        $related = Product::getRelated($product['id'], $product['category_id'], 4);

        View::render('product/show', [
            'meta_title' => $product['title'] . ' — Nucelora Skincare',
            'meta_description' => $product['short_description'] ?? 'Buy ' . $product['title'] . ' online at Nucelora.',
            'product' => $product,
            'images' => $images,
            'reviews' => $reviews,
            'related' => $related
        ]);
    }
}
