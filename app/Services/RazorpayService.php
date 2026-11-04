<?php
namespace App\Services;

use App\Models\Setting;

class RazorpayService {
    public static function getKeyId(): string {
        return Setting::get('razorpay_key_id', 'rzp_test_1DP5mmOlF5G5ag');
    }

    public static function getKeySecret(): string {
        return Setting::get('razorpay_key_secret', 'test_secret_key_lymko');
    }

    public static function verifySignature(string $orderId, string $paymentId, string $signature): bool {
        $secret = self::getKeySecret();
        $generated = hash_hmac('sha256', $orderId . '|' . $paymentId, $secret);
        return hash_equals($generated, $signature);
    }
}
