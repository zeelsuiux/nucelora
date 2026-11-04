<?php
namespace App\Models;

class CmsPage extends BaseModel {
    protected static string $table = 'cms_pages';

    public static function findBySlug(string $slug): ?array {
        $stmt = self::db()->prepare("SELECT * FROM cms_pages WHERE slug = ? AND is_active = 1 LIMIT 1");
        $stmt->execute([$slug]);
        $row = $stmt->fetch();
        return $row ?: null;
    }
}
