<?php
namespace App\Controllers;

use App\Models\Product;
use App\Models\Banner;
use App\Models\Review;
use App\Helpers\View;

class HomeController {
    public static function index(): void {
        $spotlightProducts = Product::getFeatured(8);
        $allProducts = Product::getAllWithImages('p.is_active = 1', [], 'p.id ASC', 27);
        $bestSellers = Product::getBestSellers(8);
        $rituals = Product::getAllWithImages("c.slug = 'rituals' AND p.is_active = 1", [], 'p.id ASC', 12);
        if (empty($rituals)) {
            $rituals = array_slice($allProducts, 13);
        }
        $reviews = Review::getHomepageReviews(6);
        $banners = Banner::getActive();

        View::render('home/index', [
            'meta_title' => 'Buy online Natural Skincare Products | Serums & Sunscreen | lymko.in',
            'meta_description' => 'Shop Lymko skincare Products online Vitamin C, Niacinamide & Retinol face serums, face wash, moisturizer and sunscreen. Free shipping across India.',
            'spotlightProducts' => $spotlightProducts,
            'allProducts' => $allProducts,
            'bestSellers' => $bestSellers,
            'rituals' => $rituals,
            'reviews' => $reviews,
            'banners' => $banners,
        ]);
    }
}
