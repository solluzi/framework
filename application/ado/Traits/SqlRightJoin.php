<?php
declare(strict_types=1);
namespace Application\Ado\Traits;

use Application\Interface\SQLQueryBuilder;

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
     * @return SQLQueryBuilder
     */
    public function rightJoin(string $table, string $alias, string $field1, string $field2): SQLQueryBuilder
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
        $this->query->rightJoin = "RIGHT JOIN $table $alias ON $field1 = $field2";
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
