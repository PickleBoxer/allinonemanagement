<?php

declare(strict_types=1);

namespace AllInOneManagement\Assets;

use MatthiasMullie\Minify\CSS;

class CssMinifier
{
    public static function minify(string $data, $destination)
    {
        $minifier = new CSS();
        $minifier->add($data);


        return $minifier->minify($destination);
    }
}
