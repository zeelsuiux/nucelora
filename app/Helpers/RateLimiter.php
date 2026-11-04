<?php
namespace App\Helpers;

class RateLimiter {
    private static function getStorageKey(string $action): string {
        $ip = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
        return 'rl_' . md5($action . '_' . $ip);
    }

    public static function tooManyAttempts(string $action, int $maxAttempts = 5, int $decaySeconds = 900): bool {
        Session::start();
        $key = self::getStorageKey($action);
        $data = Session::get($key);

        if (!$data || !is_array($data)) {
            return false;
        }

        if (time() > $data['expires_at']) {
            Session::remove($key);
            return false;
        }

        return ($data['attempts'] >= $maxAttempts);
    }

    public static function hit(string $action, int $decaySeconds = 900): void {
        Session::start();
        $key = self::getStorageKey($action);
        $data = Session::get($key);

        if (!$data || !is_array($data) || time() > $data['expires_at']) {
            Session::set($key, [
                'attempts' => 1,
                'expires_at' => time() + $decaySeconds
            ]);
        } else {
            $data['attempts'] += 1;
            Session::set($key, $data);
        }
    }

    public static function clear(string $action): void {
        Session::start();
        $key = self::getStorageKey($action);
        Session::remove($key);
    }

    public static function availableIn(string $action): int {
        Session::start();
        $key = self::getStorageKey($action);
        $data = Session::get($key);
        if (!$data || time() > $data['expires_at']) {
            return 0;
        }
        return max(0, $data['expires_at'] - time());
    }
}
