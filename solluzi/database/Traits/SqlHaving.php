<?php
declare(strict_types=1);
namespace Solluzi\Database\Traits;

use Solluzi\Interfaces\Database\SQLQueryBuilder;

/**
 * SqlHaving
 *  treats having requiring in sql
 */
trait SqlHaving
{
    /**
     * having method
     *  receives the values for requiring filter
     *
     * @param string $field
     * @param string $value
     * @param string $operator
     * @return SQLQueryBuilder
     */
    public function having(string $field, string $value, string $operator = "="): SQLQueryBuilder
    {
        /*
        |----------------------------------------------------------------------------------------------
        | type
        |----------------------------------------------------------------------------------------------
        |
        | verifies if requests belong to correct clause (select, update, delete)
        |
        */
        if(!in_array($this->query->type, ['select', 'update', 'delete'])){
            throw new \Exception("HAVING, só deve ser adicionado ao SELECT, UPDATE OU DELETE");
        }

        /*
        |----------------------------------------------------------------------------------------------
        | $value
        |----------------------------------------------------------------------------------------------
        |
        | verifies is the value is informed, if not then cannot pass the filter required, if yes
        | then stores in a array the where clause and the values that satisfies the request
        |
        */
        if(isset($value)){
            $this->query->having = " $field $operator '$value'";
        }

        return $this;
    }
}
