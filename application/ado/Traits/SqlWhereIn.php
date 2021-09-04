<?php
declare(strict_types=1);
namespace Application\Ado\Traits;

use Application\Interface\SQLQueryBuilder;

/**
 * 
 */
trait SqlWhereIn
{
    
    /**
     * whereIn function
     *  creates the sql using where in filter
     * 
     * @param string $field
     * @param string $value
     * @param string $operator
     * @return SQLQueryBuilder
     */
    public function whereIn(string $field, array $values, string $expression = ''): SQLQueryBuilder
    {
        /*
        |----------------------------------------------------------------------------------------------
        | type
        |----------------------------------------------------------------------------------------------
        |
        | verifies if requests belong to correct clause (select, update, delete)
        |
        */
        if(!in_array($this->query->type, ['select', 'update', 'delete']) && empty($value)){
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
        if(count($values)> 0 ){
            $in                 = str_repeat('?,', count($values) - 1) . '?';
            $this->query->where = "$field IN ($in)";
            $this->values[]     = $values;
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
