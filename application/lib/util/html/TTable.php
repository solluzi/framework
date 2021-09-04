<?php
declare (strict_types = 1);
namespace HTML;

/**
 * classe TTable
 * responsavel pela exibição de tabelas
 * @author Mauro Miranda <email@email.com>
 * @package Report
 * @license Solluzi
 */
class TTable extends TElement
{
    /**
     * método construtor
     * Instancia uam nova tabela
     */
    public function __construct()
    {
        parent::__construct('table');
    }

    /**
     * método addRow
     * Compõe um novo objeto linha (TTableRow) na Tabela
     */
    public function addRow()
    {
        // instancia objeto linha
        $row = new TTableRow();
        // armazena o objeto no conteudo do elemento table
        parent::add($row);
        return $row;
    }
}
