<?php
declare (strict_types = 1);

namespace General;

/**
 * 
 */

final class NumberString
{
    public static function getNumber($value): string
    {
        return preg_replace('/[^0-9]/', '', $value);
    }

    public static function getString($value): string
    {
        return preg_replace('/[^a-zA-Z]/', '', $value);
    }
}
