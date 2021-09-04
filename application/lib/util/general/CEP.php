<?php
declare (strict_types = 1);

/**
 * 
 */

namespace General;

final class CEP
{
    /**
     * Undocumented function
     *
     * @param string $value
     * @return string
     */
    public static function pontuado($value): string
    {
        $cep = self::naoPontuado($value);
        if ($cep == null) :
            return $cep;
        endif;

        $primeiro = substr($value, 0, 5);
        $segundo  = substr($value, 5, 3);
        return "{$primeiro}-{$segundo}";
    }

    /**
     * Undocumented function
     *
     * @param string $value
     * @return void
     */
    public static function naoPontuado($value)
    {
        $cep = preg_replace('/[^0-9]/', '', $value);
        if (strlen($cep) > 9 || strlen($cep) < 8) :
            return null;
        endif;

        return $cep;
    }
}
