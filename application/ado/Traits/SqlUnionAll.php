<?php
declare(strict_types=1);
namespace Application\Ado\Traits;

use Application\Interface\SQLQueryBuilder;

/**
 * SqlUnionAll
 *  Trait that complements sql select fron union
 */
trait SqlUnionAll
{
     /**
     * unionAll function
     *  creates union instrution for select
     * @param object $table
     * @param array $fields
     * @return SQLQueryBuilder
     */
    public function unionAll(object $table, array $fields): SQLQueryBuilder
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
            throw new \Exception("UNION ALL só deve ser adicionando a instrução SELECT");
        }

        /*
        |----------------------------------------------------------------------------------------------
        | fileds
        |----------------------------------------------------------------------------------------------
        |
        | verifies if filed are given
        |
        */
        $field = ($fields) ? implode(',',$fields) : '*';
        /*
        |----------------------------------------------------------------------------------------------
        | union
        |----------------------------------------------------------------------------------------------
        |
        | creates the union sql
        |
        */
        $this->query->union = " UNION ALL SELECT $field FROM $table->table";

        /*
        |----------------------------------------------------------------------------------------------
        | this
        |----------------------------------------------------------------------------------------------
        |
        | retun objects
        |
        */
        return $this;
    }
}
