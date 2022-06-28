<?php declare(strict_types=1);

namespace App\Helper;

use Nette\Utils\Strings;

final class ArrayHelper
{
    public static function explodeTrim(string $input): array
    {
        $output = (array)preg_split("/(\r\n|\n|\r|,|;)/",$input);
        $output = array_map(static function(string $label){
                return Strings::trim($label);
            }, $output);
        return array_filter($output);
    }
}
