<?php
declare(strict_types=1);
namespace Application\Ado\Traits;

use Application\Interface\SQLQueryBuilder;

/**
 * 
 */
trait SqlUnion
{
    /**
     * union function
     *  builds the union query 
     * 
     * @param string $table
     * @param array $fields
     * @return SQLQueryBuilder
     */
    public function union(object $table, array $fields): SQLQueryBuilder
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
            throw new \Exception("UNION só deve ser adicionando a instrução SELECT");
        }
        /*
        |----------------------------------------------------------------------------------------------
        | field
        |----------------------------------------------------------------------------------------------
        |
        | verifies if has fields
        |
        */
        $field = ($fields) ? implode(',',$fields) : '*';
        /*
        |----------------------------------------------------------------------------------------------
        | union
        |----------------------------------------------------------------------------------------------
        |
        | create a union query
        |
        */
        $this->query->union = "UNION SELECT $field FROM $table->table";
        /*
        |----------------------------------------------------------------------------------------------
        | this
        |----------------------------------------------------------------------------------------------
        |
        | return objects
        |
        */
        return $this;
    }
}
