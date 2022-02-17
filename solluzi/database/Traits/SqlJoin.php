<?php
declare(strict_types=1);
namespace Solluzi\Database\Traits;

use Solluzi\Interfaces\Database\SQLQueryBuilder;

trait SqlJoin
{
    /**
     * join function
     *  receives all datas for joining sql
     * 
     * @param string $table
     * @param string $alias
     * @param string $field1
     * @param string $field2
     * @return SQLQueryBuilder
     */
    public function join(string $table, string $alias, string $field1, string $operator, string $field2): SQLQueryBuilder
    {
        /*
        |----------------------------------------------------------------------------------------------
        | type
        |----------------------------------------------------------------------------------------------
        |
        | verifies if requests belong to correct clause (select)
        |
        */
        if(!in_array($this->query->type, ['select'])){
            throw new \Exception("JOIN só deve ser adicionando a instrução SELECT");
        }
        /*
        |----------------------------------------------------------------------------------------------
        | join
        |----------------------------------------------------------------------------------------------
        |
        | glue all parts to join a sql
        |
        */
        $this->query->join[] = " JOIN $table $alias ON $field1 $operator $field2 ";

        /*
        |----------------------------------------------------------------------------------------------
        | this
        |----------------------------------------------------------------------------------------------
        |
        | returns objects
        |
        */
        return $this;
    }
}