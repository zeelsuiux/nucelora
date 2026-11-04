<?php
namespace App\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Helpers\View;

class ShopController {
    public static function index(?string $slug = null): void {
        $categories = Category::getActive();
        $category = null;
        $where = 'p.is_active = 1';
        $params = [];

        if ($slug && $slug !== 'all') {
            if ($slug === 'best-selling') {
                $where .= ' AND p.is_best_seller = 1';
                $category = [
                    'name' => 'Best Selling Formulations',
                    'slug' => 'best-selling',
                    'description' => 'Our most loved and repurchased botanical skincare rituals across India.'
                ];
            } else {
                $category = Category::findBySlug($slug);
                if ($category) {
                    $where .= ' AND p.category_id = ?';
                    $params[] = $category['id'];
                }
            }
        }

        $products = Product::getAllWithImages($where, $params, 'p.id ASC', 50);

        View::render('shop/index', [
            'meta_title' => ($category['name'] ?? 'All Products') . ' — Nucelora Skincare',
            'meta_description' => $category['description'] ?? 'Browse all Nucelora botanical skincare products.',
            'category' => $category,
            'activeCategorySlug' => $slug,
            'categories' => $categories,
            'products' => $products
        ]);
    }

    public static function search(): void {
        $q = trim($_GET['q'] ?? '');
        $products = [];
        if (strlen($q) >= 1) {
            $products = Product::search($q, 60);
        }

        View::render('shop/search', [
            'meta_title' => ($q ? 'Search results for "' . htmlspecialchars($q) . '"' : 'Search Products') . ' — Nucelora Skincare',
            'meta_description' => 'Find targeted skincare solutions, face serums, and rituals matching your search at Nucelora.',
            'query' => $q,
            'products' => $products
        ]);
    }
}
