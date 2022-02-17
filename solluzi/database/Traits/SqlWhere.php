<?php
declare(strict_types=1);
namespace Solluzi\Database\Traits;

use Solluzi\Interfaces\Database\SQLQueryBuilder;

/**
 * 
 */
trait SqlWhere
{
    
    /**
     * Undocumented function
     *
     * @param string $field
     * @param string $value
     * @param string $operator
     * @return SQLQueryBuilder
     */
    public function where(string $field, $value = '', string $operator = '='): SQLQueryBuilder
    {
        /*
        |----------------------------------------------------------------------------------------------
        | Where
        |----------------------------------------------------------------------------------------------
        |
        | Verifies if the query being used is select, update or delete instructon
        | if not then throw an exception orienting hou this where clause must be used
        |
        */
        if(!in_array($this->query->type, ['select', 'update', 'delete']) && empty($value)){
            throw new \Exception("WHERE, só deve ser adicionado ao SELECT, UPDATE OU DELETE");
        }
        
        /*
        |----------------------------------------------------------------------------------------------
        | $value
        |----------------------------------------------------------------------------------------------
        |
        | verifies is the value is informed, if not then cannot pass the filter required, if yes
        | then stores in a array the where clause and the values that satisfies the request
        |
        */
        if($value){
            $this->query->where[] = " $field $operator ?";
            $this->values[]       = $value;
        }
        
        /*
        |----------------------------------------------------------------------------------------------
        | $this
        |----------------------------------------------------------------------------------------------
        |
        | returns the object
        |
        */
        return $this;
    }
}
