<?php
declare(strict_types=1);
namespace Application\Ado\Traits;

use Application\Interface\SQLQueryBuilder;

/**
 * 
 */
trait SqlWhereNotNull
{
    /**
     * whereNotNull function
     *  builds the query using not null filter
     * 
     * @param string $field
     * @param string $value
     * @param string $operator
     * @return SQLQueryBuilder
     */
    public function whereNotNull(string $field, string $expression = ''): SQLQueryBuilder
    {
        /*
        |----------------------------------------------------------------------------------------------
        | type
        |----------------------------------------------------------------------------------------------
        |
        | verifies if requests belong to correct clause (select, update, delete)
        |
        */
        if((!in_array($this->query->type, ['select', 'update', 'delete'])) && (!$this->query->where)){
            throw new \Exception("WHERE, só deve ser adicionado ao SELECT, UPDATE OU DELETE");
        }

        /*
        |----------------------------------------------------------------------------------------------
        | where
        |----------------------------------------------------------------------------------------------
        |
        | adds to a clause
        |
        */
        
        $this->query->where[] = "$field IS NOT NULL";
        /*
        |----------------------------------------------------------------------------------------------
        | this
        |----------------------------------------------------------------------------------------------
        |
        | return object
        |
        */
        return $this;
    }
}
