<?php
declare(strict_types=1);
namespace Application\Ado\Traits;

use Application\Interface\SQLQueryBuilder;

/**
 * 
 */
trait SqlNotBetween
{
    
    /**
     * notBetween function
     *  criates the sql to filter not between
     * @param string $field
     * @param string $value
     * @return SQLQueryBuilder
     */
    public function notBetween(string $field, array $value): SQLQueryBuilder
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
        | value
        |----------------------------------------------------------------------------------------------
        |
        | vareifies if exists values if yes then put all together
        |
        */
        if(count($value) == 2){
            $this->query->between = ($this->query->where) ? " AND $field NOT BETWEEN ? AND ?" : " WHERE $field NOT BETWEEN ? AND ?";
            $this->values[] = $value[0];
            $this->values[] = $value[1];
        }
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
