<?php
namespace App\Config;

use PDO;
use PDOException;

class Database {
    private static ?PDO $instance = null;

    public static function connect(): PDO {
        if (self::$instance === null) {
            $host = getenv('DB_HOST') ?: '127.0.0.1';
            $port = getenv('DB_PORT') ?: '3306';
            $dbname = getenv('DB_NAME') ?: 'lymko_db';
            $user = getenv('DB_USER') ?: 'root';
            $pass = getenv('DB_PASS') ?: '';

            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];

            try {
                if (file_exists('/var/run/mysqld/mysqld.sock') && ($host === '127.0.0.1' || $host === 'localhost')) {
                    $dsn = "mysql:unix_socket=/var/run/mysqld/mysqld.sock;dbname={$dbname};charset=utf8mb4";
                } else {
                    $dsn = "mysql:host={$host};port={$port};dbname={$dbname};charset=utf8mb4";
                }
                self::$instance = new PDO($dsn, $user, $pass, $options);
            } catch (PDOException $e) {
                // If socket failed, try TCP host
                try {
                    $dsn = "mysql:host={$host};port={$port};dbname={$dbname};charset=utf8mb4";
                    self::$instance = new PDO($dsn, $user, $pass, $options);
                } catch (PDOException $e2) {
                    error_log("Database connection error: " . $e2->getMessage());
                    http_response_code(500);
                    die("<!DOCTYPE html><html><head><title>Service Temporarily Unavailable</title></head><body style='font-family:sans-serif; text-align:center; padding:60px;'><h2>Service Unavailable</h2><p>Our database service is temporarily undergoing maintenance. Please try again in a few moments.</p></body></html>");
                }
            }
        }
        return self::$instance;
    }
}
