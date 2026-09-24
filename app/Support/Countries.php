<?php

namespace App\Support;

class Countries
{
    /**
     * @return array<string, array{name: string, dial: string, min: int, max: int}>
     */
    public static function all(): array
    {
        return [
            'RW' => ['name' => 'Rwanda', 'dial' => '250', 'min' => 8, 'max' => 9],
            'BI' => ['name' => 'Burundi', 'dial' => '257', 'min' => 7, 'max' => 8],
            'KE' => ['name' => 'Kenya', 'dial' => '254', 'min' => 9, 'max' => 10],
            'UG' => ['name' => 'Uganda', 'dial' => '256', 'min' => 9, 'max' => 10],
            'TZ' => ['name' => 'Tanzania', 'dial' => '255', 'min' => 9, 'max' => 10],
            'CD' => ['name' => 'DR Congo', 'dial' => '243', 'min' => 8, 'max' => 10],
            'ET' => ['name' => 'Ethiopia', 'dial' => '251', 'min' => 8, 'max' => 10],
            'ZA' => ['name' => 'South Africa', 'dial' => '27', 'min' => 9, 'max' => 10],
            'NG' => ['name' => 'Nigeria', 'dial' => '234', 'min' => 8, 'max' => 11],
            'GH' => ['name' => 'Ghana', 'dial' => '233', 'min' => 8, 'max' => 10],
            'EG' => ['name' => 'Egypt', 'dial' => '20', 'min' => 8, 'max' => 11],
            'AE' => ['name' => 'United Arab Emirates', 'dial' => '971', 'min' => 8, 'max' => 9],
            'SA' => ['name' => 'Saudi Arabia', 'dial' => '966', 'min' => 8, 'max' => 10],
            'CN' => ['name' => 'China', 'dial' => '86', 'min' => 10, 'max' => 11],
            'IN' => ['name' => 'India', 'dial' => '91', 'min' => 10, 'max' => 10],
            'JP' => ['name' => 'Japan', 'dial' => '81', 'min' => 9, 'max' => 11],
            'KR' => ['name' => 'South Korea', 'dial' => '82', 'min' => 8, 'max' => 11],
            'SG' => ['name' => 'Singapore', 'dial' => '65', 'min' => 8, 'max' => 8],
            'HK' => ['name' => 'Hong Kong', 'dial' => '852', 'min' => 8, 'max' => 8],
            'US' => ['name' => 'United States', 'dial' => '1', 'min' => 10, 'max' => 10],
            'CA' => ['name' => 'Canada', 'dial' => '1', 'min' => 10, 'max' => 10],
            'GB' => ['name' => 'United Kingdom', 'dial' => '44', 'min' => 9, 'max' => 11],
            'DE' => ['name' => 'Germany', 'dial' => '49', 'min' => 8, 'max' => 12],
            'FR' => ['name' => 'France', 'dial' => '33', 'min' => 9, 'max' => 9],
            'BE' => ['name' => 'Belgium', 'dial' => '32', 'min' => 8, 'max' => 10],
            'NL' => ['name' => 'Netherlands', 'dial' => '31', 'min' => 8, 'max' => 10],
            'IT' => ['name' => 'Italy', 'dial' => '39', 'min' => 8, 'max' => 11],
            'ES' => ['name' => 'Spain', 'dial' => '34', 'min' => 9, 'max' => 9],
            'PT' => ['name' => 'Portugal', 'dial' => '351', 'min' => 9, 'max' => 9],
            'CH' => ['name' => 'Switzerland', 'dial' => '41', 'min' => 9, 'max' => 9],
            'AT' => ['name' => 'Austria', 'dial' => '43', 'min' => 8, 'max' => 12],
            'SE' => ['name' => 'Sweden', 'dial' => '46', 'min' => 8, 'max' => 10],
            'NO' => ['name' => 'Norway', 'dial' => '47', 'min' => 8, 'max' => 8],
            'DK' => ['name' => 'Denmark', 'dial' => '45', 'min' => 8, 'max' => 8],
            'PL' => ['name' => 'Poland', 'dial' => '48', 'min' => 9, 'max' => 9],
            'TR' => ['name' => 'Türkiye', 'dial' => '90', 'min' => 10, 'max' => 10],
            'AU' => ['name' => 'Australia', 'dial' => '61', 'min' => 8, 'max' => 10],
            'NZ' => ['name' => 'New Zealand', 'dial' => '64', 'min' => 8, 'max' => 10],
            'BR' => ['name' => 'Brazil', 'dial' => '55', 'min' => 10, 'max' => 11],
            'MX' => ['name' => 'Mexico', 'dial' => '52', 'min' => 10, 'max' => 10],
        ];
    }

    public static function names(): array
    {
        return collect(self::all())
            ->mapWithKeys(fn (array $row, string $code) => [$code => $row['name']])
            ->all();
    }

    public static function name(string $code): ?string
    {
        return self::all()[$code]['name'] ?? null;
    }

    public static function dial(string $code): ?string
    {
        return self::all()[$code]['dial'] ?? null;
    }

    /**
     * Return E.164 (+2507…) or null when the number does not match the country.
     */
    public static function e164(string $code, string $phone): ?string
    {
        $meta = self::all()[$code] ?? null;
        if ($meta === null) {
            return null;
        }

        $digits = preg_replace('/\D+/', '', $phone) ?? '';
        if ($digits === '') {
            return null;
        }
        if (str_starts_with($digits, '00')) {
            $digits = substr($digits, 2);
        }

        $dial = $meta['dial'];
        $national = $digits;
        if (str_starts_with($digits, $dial) && strlen($digits) > strlen($dial)) {
            $national = substr($digits, strlen($dial));
        } elseif (str_starts_with($national, '0')) {
            $national = ltrim($national, '0');
        }

        $len = strlen($national);
        if ($len < $meta['min'] || $len > $meta['max']) {
            return null;
        }

        if ($code === 'RW' && ! str_starts_with($national, '7')) {
            return null;
        }

        if (preg_match('/^(\d)\1+$/', $national)) {
            return null;
        }

        return '+'.$dial.$national;
    }
}
