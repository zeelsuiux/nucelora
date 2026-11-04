<?php
namespace App\Models;

class Setting extends BaseModel {
    protected static string $table = 'website_settings';

    private static array $cache = [];

    public static function get(string $key, string $default = ''): string {
        if (isset(self::$cache[$key])) {
            return self::$cache[$key];
        }

        $stmt = self::db()->prepare("SELECT setting_value FROM website_settings WHERE setting_key = ? LIMIT 1");
        $stmt->execute([$key]);
        $val = $stmt->fetchColumn();

        self::$cache[$key] = ($val !== false) ? (string)$val : $default;
        return self::$cache[$key];
    }

    public static function set(string $key, string $value, string $group = 'general'): void {
        $stmt = self::db()->prepare("INSERT INTO website_settings (setting_key, setting_value, setting_group) 
                                     VALUES (?, ?, ?) 
                                     ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value)");
        $stmt->execute([$key, $value, $group]);
        self::$cache[$key] = $value;
    }

    public static function getAllGrouped(): array {
        $stmt = self::db()->query("SELECT * FROM website_settings ORDER BY setting_group ASC, id ASC");
        $rows = $stmt->fetchAll();
        $grouped = [];
        foreach ($rows as $r) {
            $grouped[$r['setting_group']][] = $r;
        }
        return $grouped;
    }
}
