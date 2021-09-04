<?php
declare(strict_types=1);
namespace Application\Ado\Traits;

use Application\Interface\SQLQueryBuilder;

/**
 * 
 */
trait SqlLimit
{
     /**
     * limit
     *  used to paginate a result
     *
     * @param integer $start
     * @param integer $offset
     * @return SQLQueryBuilder
     */
    public function limit(int $start, int $offset = 0): SQLQueryBuilder
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
            throw new \Exception("LIMIT só pode ser adicionado ao select");
        }

        /*
        |----------------------------------------------------------------------------------------------
        | limit
        |----------------------------------------------------------------------------------------------
        |
        | receives start and offset to glue in the sql clause
        |
        */
        $this->query->limit = " LIMIT " . $start . " OFFSET " . $offset;

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
