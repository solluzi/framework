<?php
declare(strict_types=1);
namespace Application\Ado\Traits;

use Application\Interface\SQLQueryBuilder;

/**
 * 
 */
trait SqlWhereNotIn
{
    
    /**
     * whereNotIn function
     *  creates the sql using where not in filter
     * @param string $field
     * @param string $value
     * @param string $operator
     * @return SQLQueryBuilder
     */
    public function whereNotIn(string $field, array $values): SQLQueryBuilder
    {
        /*
        |----------------------------------------------------------------------------------------------
        | type
        |----------------------------------------------------------------------------------------------
        |
        | verifies if requests belong to correct clause (select, update, delete)
        |
        */
        if(!in_array($this->query->type, ['select', 'update', 'delete']) && empty($values)){
            throw new \Exception("WHERE, só deve ser adicionado ao SELECT, UPDATE OU DELETE");
        }
        /*
        |----------------------------------------------------------------------------------------------
        | values
        |----------------------------------------------------------------------------------------------
        |
        | verifies if are given values, to create the sql string
        |
        */
        if(count($values) > 0){
            $in              = str_repeat('?,', count($values) - 1) . '?';
            $this->query->where = "$field NOT IN ($in)";
            $this->values[]  = $values;
        }
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
