<?php
declare(strict_types=1);
namespace Application\Ado\Traits;

use Application\Interface\SQLQueryBuilder;

/**
 * Undocumented trait
 */
trait SqlLeftJoin
{
     /**
     * leftJoin method
     *  the glue whom joins the data passed to make left join clause
     * 
     * @param string $table
     * @param string $alias
     * @param string $field1
     * @param string $field2
     * @return SQLQueryBuilder
     */
    public function leftJoin(string $table, string $alias, string $field1, string $operator, string $field2): SQLQueryBuilder
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
            throw new \Exception("LEFT JOIN só deve ser adicionando a instrução SELECT");
        }
        /*
        |----------------------------------------------------------------------------------------------
        | leftJoin
        |----------------------------------------------------------------------------------------------
        |
        | adds to array the join reqired
        |
        */
        $this->query->leftJoin[] = " LEFT JOIN $table $alias ON $field1 $operator $field2 ";

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
