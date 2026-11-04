<?php
namespace App\Config;

class App {
    public static function baseUrl(string $path = ''): string {
        $scheme = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? 'https' : 'http';
        $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
        
        // Compute base directory path from script name
        $scriptName = $_SERVER['SCRIPT_NAME'] ?? '';
        $baseDir = dirname($scriptName);
        $baseDir = str_replace('\\', '/', $baseDir);
        
        // Remove trailing public or root slash
        if (substr($baseDir, -7) === '/public') {
            $baseDir = substr($baseDir, 0, -7);
        }
        $baseDir = rtrim($baseDir, '/');

        $path = ltrim($path, '/');
        $fullPath = $baseDir . ($path !== '' ? '/' . $path : '');
        
        return $fullPath === '' ? '/' : $fullPath;
    }

    public static function asset(string $path = ''): string {
        return self::baseUrl('public/assets/' . ltrim($path, '/'));
    }

    public static function upload(string $path = ''): string {
        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }
        return self::baseUrl('public/uploads/' . ltrim($path, '/'));
    }
}
