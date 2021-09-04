<?php
declare(strict_types=1);

namespace General;

/**
 * @author Name <email@email.com>
 * @license MIT
 * @package category
 */
final class Telefone
{
    public function formata(string $value)
    {
        $telefone = preg_replace('/[^0-9]/', '', $value);
        if (strlen($telefone) == 11) :
            $ddd = substr($telefone, 0, 2);
            $ini = substr($telefone, 2, 5);
            $fim = substr($telefone, 7, 5);
            return "({$ddd}){$ini}-{$fim}";
        elseif (strlen($telefone) == 10) :
                $ddd = substr($telefone, 0, 2);
            $ini = substr($telefone, 2, 4);
            $fim = substr($telefone, 6, 4);
            return "({$ddd}){$ini}-{$fim}";
        else :
                return null;
        endif;
    }
}
