<?php
declare (strict_types = 1);

namespace General;

/**
 * 
 */

final class CNPJ
{
    public static function pontuado($value)
    {
        $cnpj = self::naoPontuado($value);
        if ($cnpj == null) :
            return $cnpj;
        endif;

        $primeiro = substr($cnpj, 0, 2);
        $segundo  = substr($cnpj, 2, 3);
        $terceiro = substr($cnpj, 5, 3);
        $quarto   = substr($cnpj, 8, 4);
        $quinto   = substr($cnpj, 12, 2);
        return "{$primeiro}.{$segundo}.{$terceiro}/{$quarto}-{$quinto}";
    }

    public static function naoPontuado($value)
    {
        $cnpj = preg_replace('/[^0-9]/', '', $value);
        if (strlen($cnpj) > 14 || strlen($cnpj) < 14) :
            return null;
        endif;

        return $cnpj;
    }
}
