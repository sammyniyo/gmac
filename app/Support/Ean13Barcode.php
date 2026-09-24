<?php

namespace App\Support;

class Ean13Barcode
{
    private const PARITY = [
        'LLLLLL', 'LLGLGG', 'LLGGLG', 'LLGGGL', 'LGLLGG',
        'LGGLLG', 'LGGGLL', 'LGLGLG', 'LGLGGL', 'LGGLGL',
    ];

    private const L = [
        '0001101', '0011001', '0010011', '0111101', '0100011',
        '0110001', '0101111', '0111011', '0110111', '0001011',
    ];

    private const G = [
        '0100111', '0110011', '0011011', '0100001', '0011101',
        '0111001', '0000101', '0010001', '0001001', '0010111',
    ];

    private const R = [
        '1110010', '1100110', '1101100', '1000010', '1011100',
        '1001110', '1010000', '1000100', '1001000', '1110100',
    ];

    public static function svg(string $code, int $barWidth = 2, int $height = 88): string
    {
        $digits = preg_replace('/\D/', '', $code) ?? '';
        $bits = strlen($digits) === 13
            ? self::ean13Bits($digits)
            : self::fallbackBits($digits !== '' ? $digits : $code);

        $quiet = 10;
        $width = (strlen($bits) + ($quiet * 2)) * $barWidth;
        $rects = '';
        $x = $quiet * $barWidth;

        foreach (str_split($bits) as $bit) {
            if ($bit === '1') {
                $rects .= '<rect x="'.$x.'" y="0" width="'.$barWidth.'" height="'.$height.'" fill="#1a120c"/>';
            }
            $x += $barWidth;
        }

        return '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 '.$width.' '.$height.'" width="'.$width.'" height="'.$height.'" role="img" aria-label="Barcode '.$digits.'">'.$rects.'</svg>';
    }

    private static function ean13Bits(string $digits): string
    {
        $first = (int) $digits[0];
        $parity = self::PARITY[$first];
        $bits = '101';

        for ($i = 1; $i <= 6; $i++) {
            $n = (int) $digits[$i];
            $bits .= $parity[$i - 1] === 'G' ? self::G[$n] : self::L[$n];
        }

        $bits .= '01010';

        for ($i = 7; $i <= 12; $i++) {
            $bits .= self::R[(int) $digits[$i]];
        }

        return $bits.'101';
    }

    private static function fallbackBits(string $value): string
    {
        $bits = '101';
        foreach (str_split($value) as $char) {
            $n = is_numeric($char) ? (int) $char : (ord($char) % 10);
            $bits .= self::L[$n].'0';
        }

        return $bits.'101';
    }
}
