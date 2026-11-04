<?php
namespace App\Models;

class Review extends BaseModel {
    protected static string $table = 'product_reviews';

    public static function getHomepageReviews(int $limit = 6): array {
        $sql = "SELECT r.*, p.title as product_title, p.slug as product_slug, pi.image_url as product_image
                FROM product_reviews r
                JOIN products p ON p.id = r.product_id
                LEFT JOIN product_images pi ON pi.product_id = p.id AND pi.is_primary = 1
                WHERE r.is_approved = 1
                ORDER BY r.rating DESC, r.id DESC
                LIMIT " . (int)$limit;
        return self::db()->query($sql)->fetchAll();
    }
}
