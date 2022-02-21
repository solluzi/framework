<?php
declare(strict_types=1);
namespace Solluzi\Database\Traits;

use Solluzi\Interfaces\SQLQueryBuilder;

/**
 * 
 */
trait SqlRightJoin
{
    /**
     * rightJoin function
     *  the glue whom joins the data passed to make right join clause
     * 
     * @param string $table
     * @param string $alias
     * @param string $field1
     * @param string $field2
     * @param string $operator
     * @return SQLQueryBuilder
     */
    public function rightJoin(string $table, string $alias, string $field1, string $operator, string $field2): SQLQueryBuilder
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
            throw new \Exception("RIGHT JOIN só deve ser adicionando a instrução SELECT");
        }
        /*
        |----------------------------------------------------------------------------------------------
        | rightJoin
        |----------------------------------------------------------------------------------------------
        |
        | adds to array the join reqired
        |
        */
        $this->query->rightJoin = " RIGHT JOIN $table $alias ON $field1 $operator $field2 ";
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
