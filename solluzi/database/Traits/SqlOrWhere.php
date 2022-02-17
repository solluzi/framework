<?php
declare(strict_types=1);
namespace Solluzi\Database\Traits;

use Solluzi\Interfaces\Database\SQLQueryBuilder;

/**
 * 
 */
trait SqlOrWhere
{
    /**
     * orWhere function
     *
     * @param string $field
     * @param string $value
     * @param string $operator
     * @return SQLQueryBuilder
     */
    public function orWhere(string $field, $value, string $operator = "="): SQLQueryBuilder
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
        | verifies if exists where clause if yes them make the query
        |
        */
        if($this->query->where && $value){
            $this->query->orWhere[] = "$field $operator ?";
            $this->values[]         = $value;
        }

        /*
        |----------------------------------------------------------------------------------------------
        | where
        |----------------------------------------------------------------------------------------------
        |
        | if not then put where to the clause
        |
        */
        if(!$this->query->where && $value){
            $this->query->where[] = "$field $operator ?";
            $this->values[]       = $value;
        }
        
        return $this;
    }
}
