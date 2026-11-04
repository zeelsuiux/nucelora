<?php
namespace App\Models;

class Banner extends BaseModel {
    protected static string $table = 'banners';

    public static function getActive(): array {
        $sql = "SELECT * FROM banners WHERE is_active = 1 ORDER BY sort_order ASC, id ASC";
        return self::db()->query($sql)->fetchAll();
    }
}
