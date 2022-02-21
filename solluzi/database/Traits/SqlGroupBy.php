<?php
declare(strict_types=1);
namespace Solluzi\Database\Traits;

use Solluzi\Interfaces\SQLQueryBuilder;

/**
 * SqlGroupBy Trait
 *  Formats the group sql clause
 */
trait SqlGroupBy
{
     /**
     * groupBy method
     *  formats the group requisition
     * @param array $fields
     * @return SQLQueryBuilder
     */
    public function groupBy(array $fields): SQLQueryBuilder
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
            throw new \Exception("GROUP BY, só deve ser adicionado ao SELECT, UPDATE OU DELETE");
        }

        /*
        |----------------------------------------------------------------------------------------------
        | group
        |----------------------------------------------------------------------------------------------
        |
        | add fields to group object
        |
        */
        $this->query->group = $fields;

        /*
        |----------------------------------------------------------------------------------------------
        | this
        |----------------------------------------------------------------------------------------------
        |
        | returns the object
        |
        */
        return $this;
    }
}
