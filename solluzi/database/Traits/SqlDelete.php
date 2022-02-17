<?php
declare(strict_types=1);
namespace Solluzi\Database\Traits;

use Solluzi\Interfaces\Database\SQLQueryBuilder;

trait SqlDelete
{
     /**
     * delete function:
     *  stores the delete instruction to run in database
     *
     * @return SQLQueryBuilder
     */
    public function delete(): SQLQueryBuilder
    {
        /*
        |----------------------------------------------------------------------------------------------
        | reset
        |----------------------------------------------------------------------------------------------
        |
        | Clears all sql instruction in variables
        |
        */
        $this->reset();

        /*
        |----------------------------------------------------------------------------------------------
        | base
        |----------------------------------------------------------------------------------------------
        |
        | stores the base instruction in object
        |
        */
        $this->query->base = "DELETE FROM $this->table ";

        /*
        |----------------------------------------------------------------------------------------------
        | type
        |----------------------------------------------------------------------------------------------
        |
        | informs with type the instruction is (select, insert, delete or update)
        |
        */
        $this->query->type = "delete";

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