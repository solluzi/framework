<?php
declare (strict_types = 1);
namespace HTML;

/**
 * classe TTableRow
 * Responsavel pela exibição de uma linha de uma tabela
 */
class TTableRow extends TElement
{
    /**
     * método construtor
     * instancia uma nova linha
     */
    public function __construct()
    {
        parent::__construct('tr');
    }

    /**
     * método addCell
     * Compõe um novo bjeto celula (TTableCell) à linha
     * @param $value = contéudo da celula
     */
    public function addCell($value)
    {
        // instancia objeto célula
        $cell = new TTableCell($value);
        //adiciona o objeto no conteudo da linha
        parent::add($cell);
        // retorna o objeto instanciado
        return $cell;
    }
}
