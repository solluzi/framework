<?php
declare(strict_types=1);
namespace Application\Ado;

use Application\Interface\SQLQueryBuilder;

/**
 * Este Builder é compativel com o PostgreSQL. Ainda que seja similiar com
 * o MySQL, ainda assim existem diferenças. para reutilizar o código base, 
 * extendemos do MySQL builder, sobrescrevendo alguns dos passos
 */

class PostgresQueryBuilder extends MySQLQueryBuilder
{
    /**
     * Entre outras coisas, PostgreSQL tem pequena diferença 
     * na sintaxe LIMIT
     */
    public function limit(int $start, int $offset = 0): SQLQueryBuilder
    {
        parent::limit($start, $offset);

        $this->query->limit = " LIMIT " . $start . " OFFSET " . $offset;

        return $this;
    }

}