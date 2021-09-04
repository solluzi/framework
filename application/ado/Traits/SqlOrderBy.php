<?php
declare(strict_types=1);
namespace Application\Ado\Traits;

use Application\Interface\SQLQueryBuilder;

/**
 * 
 */
trait SqlOrderBy
{
    /**
     * orderby function
     *  make select ordering by given column
     * @param string $field
     * @param string $direction
     * @return SQLQueryBuilder
     */
    public function orderBy(string $field, string $direction = 'ASC'): SQLQueryBuilder
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
            throw new \Exception("ORDER BY, só deve ser adicionado ao SELECT, UPDATE OU DELETE");
        }
        /*
        |----------------------------------------------------------------------------------------------
        | orderBy
        |----------------------------------------------------------------------------------------------
        |
        | makes ordering by and direction
        |
        */
        $this->query->orderBy = " ORDER BY $field $direction";

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
