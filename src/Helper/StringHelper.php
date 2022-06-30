<?php

declare(strict_types=1);

namespace App\Helper;

use Nette\Utils\Strings;
use function strlen;

final class StringHelper
{
    public static function hasPhysicalBookAttributes(string $string): bool
    {
        return Strings::contains($string, 'Taschenbuch');
    }
    public static function hasTags(string $string): bool
    {
        return Strings::contains($string, '<') && Strings::contains($string, '>');
    }

    public static function startsWith(string $subject, string $needle): bool
    {
        return Strings::startsWith($subject, $needle);
    }

    public static function endsWith(string $string, string $needle): bool
    {
        return Strings::endsWith($string, $needle);
    }

    public static function getBefore(string $subject, string $pattern): string
    {
        return Strings::before($subject, $pattern) ?: '';
    }

    public static function match(string $subject, string $pattern): ?array
    {
        return Strings::match($subject, $pattern);
    }

    public static function contains(string $haystack, string $needle, bool $caseInsensitive = true): bool
    {
        if($caseInsensitive){
            return Strings::contains(strtolower($haystack), strtolower($needle));
        }
        return Strings::contains($haystack, $needle);
    }

    public static function human_filesize(string $bytes, ?int $decimals = 2): string
    {
        $sz = ['Byte', 'KB', 'MB', 'GB', 'TB', 'PB'];
        $factor = (int) floor((strlen($bytes) - 1) / 3);

        return sprintf("%.{$decimals}f", $bytes / (1024 ** $factor)).$sz[$factor];
    }

    public static function sonderzeichen(string $string): string
    {
        $search = ['Ä', 'Ö', 'Ü', 'ä', 'ö', 'ü', 'ß', '´'];
        $replace = ['Ae', 'Oe', 'Ue', 'ae', 'oe', 'ue', 'ss', ''];

        return str_replace($search, $replace, $string);
    }

    public static function truncate(string $s, int $maxLen, string $append = "\u{2026}"): string
    {
        return Strings::truncate($s, $maxLen,$append);
    }

    public static function ensureUtf8(string $string): string
    {
        if (preg_match('%^(?:
              [\x09\x0A\x0D\x20-\x7E]            # ASCII
            | [\xC2-\xDF][\x80-\xBF]             # non-overlong 2-byte
            | \xE0[\xA0-\xBF][\x80-\xBF]         # excluding overlongs
            | [\xE1-\xEC\xEE\xEF][\x80-\xBF]{2}  # straight 3-byte
            | \xED[\x80-\x9F][\x80-\xBF]         # excluding surrogates
            | \xF0[\x90-\xBF][\x80-\xBF]{2}      # planes 1-3
            | [\xF1-\xF3][\x80-\xBF]{3}          # planes 4-15
            | \xF4[\x80-\x8F][\x80-\xBF]{2}      # plane 16
        )*$%xs', $string)){
            return $string;
        }
        return iconv('CP1252', 'UTF-8//IGNORE', $string);
    }

    public static function normalize(string $string): string
    {
        return Strings::normalize(self::ensureUtf8($string));
    }
}
