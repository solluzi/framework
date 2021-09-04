<?php
declare (strict_types = 1);
namespace HTML;

/**
 * classe TTableCel
 * Responsável pela exibição de uma celula de uma tabela
 */
class TTableCell extends TElement
{
    /**
     * método construtor
     * Instancia uma noca celula
     * @param $value = conteúdo da célula
     */
    public function __construct($value)
    {
        parent::__construct('td');
        parent::add($value);
    }
}
