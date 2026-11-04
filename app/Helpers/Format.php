<?php
namespace App\Helpers;

class Format {
    public static function money(float|int|string $amount): string {
        $num = (float)$amount;
        return 'Rs. ' . number_format($num, 0, '.', ',');
    }

    public static function date(?string $date, string $format = 'd M Y, h:i A'): string {
        if (!$date) return '-';
        return date($format, strtotime($date));
    }

    public static function discountPercent(float|int $price, float|int $mrp): int {
        if ($mrp <= $price || $mrp <= 0) return 0;
        return (int)round((($mrp - $price) / $mrp) * 100);
    }
}
