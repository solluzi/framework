<?php
declare (strict_types = 1);
namespace General;

/**
 * 
 */

final class NumberFormat
{
    public static function decimal($var)
    {
        $_f1 = str_replace(".", "", $var);
        $_f2 = str_replace(",", ".", $_f1);
        return $_f2;
    }

    public static function returnDecimal($var)
    {
        return number_format($var, 2, ',', '.');
    }
}
