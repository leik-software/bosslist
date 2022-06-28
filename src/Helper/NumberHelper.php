<?php declare(strict_types=1);

namespace App\Helper;

final class NumberHelper
{
    public static function formatPrice($price, int $minDecimals = 2): string
    {
        $price = self::tofloat($price);
        $split = explode('.', (string) $price);
        $minDecimals = (isset($split[1]) && \strlen($split[1]) > $minDecimals) ? \strlen($split[1]) : $minDecimals;
        if($minDecimals === 0){
            return $split[0];
        }
        return number_format($price, $minDecimals, ',', '.');
    }

    public static function tofloat($num): float
    {
        if (!$num) {
            return 0.0;
        }
        if(is_float($num)){
            return $num;
        }
        if(is_int($num)){
            $num = (string)$num;
        }
        $dotPos = strrpos($num, '.');
        $commaPos = strrpos($num, ',');
        $sep = false;
        if (($dotPos > $commaPos) && $dotPos) {
            $sep = $dotPos;
        } elseif (($commaPos > $dotPos) && $commaPos) {
            $sep = $commaPos;
        }

        if (!$sep) {
            return (float) preg_replace('/\D/', '', $num);
        }

        return (float) (preg_replace('/\D/', '', substr($num, 0, $sep)).'.'.
            preg_replace('/\D/', '', substr($num, $sep + 1, \strlen($num))));
    }
}
