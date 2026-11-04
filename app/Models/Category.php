<?php
namespace App\Models;

class Category extends BaseModel {
    protected static string $table = 'categories';

    public static function getActive(): array {
        return self::where('is_active', 1);
    }

    public static function findBySlug(string $slug): ?array {
        return self::findBy('slug', $slug);
    }
}
