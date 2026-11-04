<?php
namespace App\Models;

use App\Config\Database;
use PDO;

abstract class BaseModel {
    protected static string $table = '';
    protected static string $primaryKey = 'id';

    protected static function db(): PDO {
        return Database::connect();
    }

    public static function all(string $orderBy = 'id DESC'): array {
        $stmt = self::db()->query("SELECT * FROM `" . static::$table . "` ORDER BY " . $orderBy);
        return $stmt->fetchAll();
    }

    public static function find(int|string $id): ?array {
        $stmt = self::db()->prepare("SELECT * FROM `" . static::$table . "` WHERE `" . static::$primaryKey . "` = ? LIMIT 1");
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public static function where(string $column, mixed $value, string $operator = '='): array {
        $stmt = self::db()->prepare("SELECT * FROM `" . static::$table . "` WHERE `{$column}` {$operator} ?");
        $stmt->execute([$value]);
        return $stmt->fetchAll();
    }

    public static function findBy(string $column, mixed $value): ?array {
        $stmt = self::db()->prepare("SELECT * FROM `" . static::$table . "` WHERE `{$column}` = ? LIMIT 1");
        $stmt->execute([$value]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public static function count(string $where = '', array $params = []): int {
        $sql = "SELECT COUNT(*) FROM `" . static::$table . "`";
        if ($where !== '') {
            $sql .= " WHERE " . $where;
        }
        $stmt = self::db()->prepare($sql);
        $stmt->execute($params);
        return (int)$stmt->fetchColumn();
    }

    public static function insert(array $data): int {
        $fields = array_keys($data);
        $placeholders = array_fill(0, count($fields), '?');
        $sql = "INSERT INTO `" . static::$table . "` (`" . implode('`, `', $fields) . "`) VALUES (" . implode(', ', $placeholders) . ")";
        $stmt = self::db()->prepare($sql);
        $stmt->execute(array_values($data));
        return (int)self::db()->lastInsertId();
    }

    public static function update(int|string $id, array $data): bool {
        $fields = array_keys($data);
        $setClauses = array_map(fn($f) => "`{$f}` = ?", $fields);
        $sql = "UPDATE `" . static::$table . "` SET " . implode(', ', $setClauses) . " WHERE `" . static::$primaryKey . "` = ?";
        $params = array_values($data);
        $params[] = $id;
        $stmt = self::db()->prepare($sql);
        return $stmt->execute($params);
    }

    public static function delete(int|string $id): bool {
        $stmt = self::db()->prepare("DELETE FROM `" . static::$table . "` WHERE `" . static::$primaryKey . "` = ?");
        return $stmt->execute([$id]);
    }
}
