<?php
namespace App\Models;

class Coupon extends BaseModel {
    protected static string $table = 'coupons';

    public static function findValid(string $code, float $cartTotal): ?array {
        $stmt = self::db()->prepare("SELECT * FROM coupons WHERE code = ? AND is_active = 1 LIMIT 1");
        $stmt->execute([trim($code)]);
        $coupon = $stmt->fetch();
        if (!$coupon) return null;

        if ($cartTotal < (float)$coupon['min_order_amount']) {
            return null;
        }

        if ($coupon['expires_at'] && strtotime($coupon['expires_at']) < time()) {
            return null;
        }

        if ($coupon['usage_limit_total'] && $coupon['times_used'] >= $coupon['usage_limit_total']) {
            return null;
        }

        return $coupon;
    }

    public static function calculateDiscount(array $coupon, float $cartTotal): float {
        if ($coupon['discount_type'] === 'percentage') {
            $discount = ($cartTotal * (float)$coupon['discount_value']) / 100.0;
            if (!empty($coupon['max_discount_amount']) && $discount > (float)$coupon['max_discount_amount']) {
                $discount = (float)$coupon['max_discount_amount'];
            }
            return round($discount, 2);
        } else {
            return round(min($cartTotal, (float)$coupon['discount_value']), 2);
        }
    }
}
