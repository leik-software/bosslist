<?php

declare(strict_types=1);

namespace App\Helper;

use kornrunner\Blurhash\Blurhash;

final class BlurHashHelper
{
    public static function encodeHashFromString(string $content): string
    {
        $image = imagecreatefromstring($content);
        $width = imagesx($image);
        $height = imagesy($image);
        $max_width = 25;
        if( $width > $max_width ) {
            $image = imagescale($image, $max_width);
            $width = imagesx($image);
            $height = imagesy($image);
        }
        $pixels = [];
        for ($y = 0; $y < $height; ++$y) {
            $row = [];
            for ($x = 0; $x < $width; ++$x) {
                $index = imagecolorat($image, $x, $y);
                $colors = imagecolorsforindex($image, $index);

                $row[] = [$colors['red'], $colors['green'], $colors['blue']];
            }
            $pixels[] = $row;
        }

        $components_x = 4;
        $components_y = 5;
        return Blurhash::encode($pixels, $components_x, $components_y);
    }

    public static function encodeHashFromFilename(string $filename): string
    {
        return self::encodeHashFromString(file_get_contents($filename));
    }

    public static function decodeHash(string $hash, int $width, int $height): void
    {

        $pixels = Blurhash::decode($hash, $width, $height);
        $image  = imagecreatetruecolor($width, $height);
        for ($y = 0; $y < $height; ++$y) {
            for ($x = 0; $x < $width; ++$x) {
                [$r, $g, $b] = $pixels[$y][$x];
                if($r > 255) { $r = 255; }
                if($g > 255) { $g = 255; }
                if($b > 255) { $b = 255; }
                if($r < 0) { $r = 0; }
                if($g < 0) { $g = 0; }
                if($b < 0) { $b = 0; }
                imagesetpixel($image, $x, $y, imagecolorallocate($image, $r, $g, $b));
            }
        }
        imagejpeg($image, null, 85);
    }
}
