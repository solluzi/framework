<?php
declare(strict_types=1);
namespace Solluzi\Database\Traits;

use Solluzi\Interfaces\SQLQueryBuilder;

trait SqlInstruction
{
    /**
     * instrution
     *  receives plain sql instrunction
     *
     * @param array $instruction
     * @return SQLQueryBuilder
     */
    public function instruction(string $instruction): SQLQueryBuilder
    {
        /*
        |----------------------------------------------------------------------------------------------
        | reset
        |----------------------------------------------------------------------------------------------
        |
        | clears the sql object
        |
        */
        $this->reset();

        /*
        |----------------------------------------------------------------------------------------------
        | base
        |----------------------------------------------------------------------------------------------
        |
        | store the sql instruction into query base (select, update, delete or a function)
        |
        */
        $this->query->base = $instruction .' '. $this->table;
        /*
        |----------------------------------------------------------------------------------------------
        | type
        |----------------------------------------------------------------------------------------------
        |
        | verifies if requests belong to correct clause (select, update, delete)
        |
        */
        $this->query->type = $instruction;

        /*
        |----------------------------------------------------------------------------------------------
        | this
        |----------------------------------------------------------------------------------------------
        |
        | retuns the object
        |
        */
        return $this;
    }
}