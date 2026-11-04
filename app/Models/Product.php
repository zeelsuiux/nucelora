<?php
namespace App\Models;

use PDO;

class Product extends BaseModel {
    protected static string $table = 'products';

    public static function getFeatured(int $limit = 8): array {
        $sql = "SELECT p.*, pi.image_url, c.name as category_name 
                FROM products p
                LEFT JOIN product_images pi ON pi.product_id = p.id AND pi.is_primary = 1
                LEFT JOIN categories c ON c.id = p.category_id
                WHERE p.is_active = 1 AND p.is_featured = 1
                ORDER BY p.id ASC
                LIMIT " . (int)$limit;
        return self::db()->query($sql)->fetchAll();
    }

    public static function getBestSellers(int $limit = 8): array {
        $sql = "SELECT p.*, pi.image_url, c.name as category_name 
                FROM products p
                LEFT JOIN product_images pi ON pi.product_id = p.id AND pi.is_primary = 1
                LEFT JOIN categories c ON c.id = p.category_id
                WHERE p.is_active = 1 AND p.is_best_seller = 1
                ORDER BY p.id ASC
                LIMIT " . (int)$limit;
        return self::db()->query($sql)->fetchAll();
    }

    public static function getAllWithImages(string $where = '1=1', array $params = [], string $order = 'p.id ASC', int $limit = 100): array {
        $sql = "SELECT p.*, pi.image_url, c.name as category_name, c.slug as category_slug
                FROM products p
                LEFT JOIN product_images pi ON pi.product_id = p.id AND pi.is_primary = 1
                LEFT JOIN categories c ON c.id = p.category_id
                WHERE {$where}
                ORDER BY {$order}
                LIMIT {$limit}";
        $stmt = self::db()->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public static function findBySlug(string $slug): ?array {
        $sql = "SELECT p.*, pi.image_url, c.name as category_name, c.slug as category_slug
                FROM products p
                LEFT JOIN product_images pi ON pi.product_id = p.id AND pi.is_primary = 1
                LEFT JOIN categories c ON c.id = p.category_id
                WHERE p.slug = ? AND p.is_active = 1
                LIMIT 1";
        $stmt = self::db()->prepare($sql);
        $stmt->execute([$slug]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public static function getImages(int $productId): array {
        $stmt = self::db()->prepare("SELECT * FROM product_images WHERE product_id = ? ORDER BY sort_order ASC, id ASC");
        $stmt->execute([$productId]);
        return $stmt->fetchAll();
    }

    public static function getReviews(int $productId): array {
        $stmt = self::db()->prepare("SELECT * FROM product_reviews WHERE product_id = ? AND is_approved = 1 ORDER BY id DESC");
        $stmt->execute([$productId]);
        return $stmt->fetchAll();
    }

    public static function getRelated(int $productId, ?int $categoryId, int $limit = 4): array {
        $sql = "SELECT p.*, pi.image_url 
                FROM products p
                LEFT JOIN product_images pi ON pi.product_id = p.id AND pi.is_primary = 1
                WHERE p.id != ? AND p.is_active = 1";
        $params = [$productId];
        if ($categoryId) {
            $sql .= " AND p.category_id = ?";
            $params[] = $categoryId;
        }
        $sql .= " ORDER BY RAND() LIMIT " . (int)$limit;
        $stmt = self::db()->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public static function search(string $query, int $limit = 20): array {
        $term = '%' . trim($query) . '%';
        $sql = "SELECT p.*, pi.image_url, c.name as category_name
                FROM products p
                LEFT JOIN product_images pi ON pi.product_id = p.id AND pi.is_primary = 1
                LEFT JOIN categories c ON c.id = p.category_id
                WHERE p.is_active = 1 AND (p.title LIKE ? OR p.short_description LIKE ? OR p.sku LIKE ? OR p.benefits LIKE ?)
                ORDER BY p.is_best_seller DESC, p.title ASC
                LIMIT {$limit}";
        $stmt = self::db()->prepare($sql);
        $stmt->execute([$term, $term, $term, $term]);
        return $stmt->fetchAll();
    }
}
