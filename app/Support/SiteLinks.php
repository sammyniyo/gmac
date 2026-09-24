<?php

namespace App\Support;

use App\Models\Setting;

class SiteLinks
{
    public const INSTAGRAM = 'https://www.instagram.com/gmac.coffee/';

    public const FACEBOOK = 'https://www.facebook.com/profile.php?id=100088696975817';

    public static function instagram(): string
    {
        return self::usable(self::setting(['social_instagram', 'instagram_url'])) ?: self::INSTAGRAM;
    }

    public static function facebook(): string
    {
        return self::usable(self::setting(['social_facebook', 'facebook_url'])) ?: self::FACEBOOK;
    }

    private static function setting(array $keys): ?string
    {
        foreach ($keys as $key) {
            $value = Setting::where('key', $key)->value('value');
            if (is_string($value) && $value !== '') {
                return $value;
            }
        }

        return null;
    }

    private static function usable(?string $value): ?string
    {
        if (! is_string($value) || $value === '' || $value === '#') {
            return null;
        }

        if (! preg_match('#^https?://#i', $value)) {
            return null;
        }

        return $value;
    }
}
