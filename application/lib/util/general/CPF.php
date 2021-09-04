<?php
declare (strict_types = 1);

namespace General;

/**
 * Undocumented class
 */
final class CPF
{
    public static function pontuado($value)
    {
        $cpf = preg_replace('/[^0-9]/', '', $value);

        if (strlen($cpf) > 11 | strlen($cpf) < 11) {
            return null;
        }

        $primeiro = substr($cpf, 0, 3);
        $segundo  = substr($cpf, 3, 3);
        $terceiro = substr($cpf, 6, 3);
        $quarto   = substr($cpf, 9, 2);
        return "{$primeiro}.{$segundo}.{$terceiro}-{$quarto}";
    }

    public static function naoPontuado($value)
    {
        $cpf = preg_replace('/[^0-9]/', '', $value);
        if (strlen($cpf) > 11 | strlen($cpf) < 11) {
            return null;
        }
        return $cpf;
    }
}
