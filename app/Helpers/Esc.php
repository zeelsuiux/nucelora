<?php
namespace App\Helpers;

class Esc {
    public static function html(?string $text): string {
        return htmlspecialchars((string)$text, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }

    public static function attr(?string $text): string {
        return htmlspecialchars((string)$text, ENT_QUOTES, 'UTF-8');
    }

    public static function js(?string $text): string {
        return json_encode((string)$text, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
    }
}
