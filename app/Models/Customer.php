<?php
namespace App\Models;

class Customer extends BaseModel {
    protected static string $table = 'customers';

    public static function findByEmail(string $email): ?array {
        return self::findBy('email', trim(strtolower($email)));
    }

    public static function getAddresses(int $customerId): array {
        $stmt = self::db()->prepare("SELECT * FROM customer_addresses WHERE customer_id = ? ORDER BY is_default DESC, id DESC");
        $stmt->execute([$customerId]);
        return $stmt->fetchAll();
    }

    public static function getDefaultAddress(int $customerId): ?array {
        $stmt = self::db()->prepare("SELECT * FROM customer_addresses WHERE customer_id = ? AND is_default = 1 LIMIT 1");
        $stmt->execute([$customerId]);
        $row = $stmt->fetch();
        return $row ?: null;
    }
}
