<?php
declare(strict_types=1);
namespace Application\Ado\Traits;

use Application\Interface\SQLQueryBuilder;

/**
 * 
 */
trait SqlBetween
{
    
    /**
     * Undocumented function
     *
     * @param string $field
     * @param string $value
     * @param string $operator
     * @return SQLQueryBuilder
     */
    public function between(string $field, array $value): SQLQueryBuilder
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
        if(count($value) == 2){
            $this->query->between = ($this->query->where) ? " AND $field BETWEEN ? AND ?" : " WHERE $field BETWEEN ? AND ?";
            $this->values[] = $value[0];
            $this->values[] = $value[1];
        }

        return $this;
    }
}
