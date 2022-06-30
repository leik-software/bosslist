<?php declare(strict_types=1);

namespace App\Helper;

use Nette\Utils\FileSystem;
use Ouzo\Utilities\Files;
use function count;

final class FileHelper
{
    public static function makeValidFilename(string $filename): string
    {
        $translitTable = TranslitTable::getTranlitTable();
        $filename = str_replace(array_keys($translitTable), array_values($translitTable), $filename);

        return preg_replace('/[^A-Za-z0-9_.-]/', '_', $filename);
    }

    public static function createDir(string $dir, int $mode = 0777): void
    {
        FileSystem::createDir($dir, $mode);
    }

    public static function rename(string $from, string $to): void
    {
        FileSystem::rename($from, $to);
    }

    public static function deleteIfExists(string $filename): void
    {
        Files::deleteIfExists($filename);
    }

    public static function makeValidPath(string ...$paths): string
    {
        $outputPath = '';
        foreach ($paths as $path) {
            if (!$outputPath) {
                $outputPath = rtrim($path, '/');

                continue;
            }
            $outputPath .= '/'.trim($path, '/');
        }

        return $outputPath;
    }

    public static function getRandomSubfolderTree(): string
    {
        $str = 'abcdefghijklmnopqrstuvwxyz0123456789';
        $randomChars1 = $str[random_int(0, strlen($str)-1)].$str[random_int(0, strlen($str)-1)];
        $randomChars2 = $str[random_int(0, strlen($str)-1)].$str[random_int(0, strlen($str)-1)];
        $randomChars3 = $str[random_int(0, strlen($str)-1)].$str[random_int(0, strlen($str)-1)];
        return sprintf('%s/%s/%s', $randomChars1, $randomChars2, $randomChars3);

    }

    public static function getMimeType(string $filename): string
    {
        $idx = explode('.', $filename);
        $count_explode = count($idx);
        $idx = strtolower($idx[$count_explode - 1]);

        $mimet = [
            'txt' => 'text/plain',
            'htm' => 'text/html',
            'html' => 'text/html',
            'php' => 'text/html',
            'css' => 'text/css',
            'js' => 'application/javascript',
            'json' => 'application/json',
            'xml' => 'application/xml',
            'swf' => 'application/x-shockwave-flash',
            'flv' => 'video/x-flv',

            // images
            'png' => 'image/png',
            'jpe' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'jpg' => 'image/jpeg',
            'gif' => 'image/gif',
            'bmp' => 'image/bmp',
            'ico' => 'image/vnd.microsoft.icon',
            'tiff' => 'image/tiff',
            'tif' => 'image/tiff',
            'svg' => 'image/svg+xml',
            'svgz' => 'image/svg+xml',

            // archives
            'zip' => 'application/zip',
            'rar' => 'application/x-rar-compressed',
            'exe' => 'application/x-msdownload',
            'msi' => 'application/x-msdownload',
            'cab' => 'application/vnd.ms-cab-compressed',

            // audio/video
            'mp3' => 'audio/mpeg',
            'qt' => 'video/quicktime',
            'mov' => 'video/quicktime',

            // adobe
            'pdf' => 'application/pdf',
            'psd' => 'image/vnd.adobe.photoshop',
            'ai' => 'application/postscript',
            'eps' => 'application/postscript',
            'ps' => 'application/postscript',

            // ms office
            'doc' => 'application/msword',
            'rtf' => 'application/rtf',
            'xls' => 'application/vnd.ms-excel',
            'ppt' => 'application/vnd.ms-powerpoint',
            'docx' => 'application/msword',
            'xlsx' => 'application/vnd.ms-excel',
            'pptx' => 'application/vnd.ms-powerpoint',

            // open office
            'odt' => 'application/vnd.oasis.opendocument.text',
            'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
        ];

        return $mimet[$idx] ?? 'application/octet-stream';
    }

    public static function file_get_contents_ssl($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_REFERER, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3000); // 3 sec.
        curl_setopt($ch, CURLOPT_TIMEOUT, 10000); // 10 sec.
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
}
