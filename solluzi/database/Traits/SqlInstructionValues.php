<?php
declare(strict_types=1);
namespace Solluzi\Database\Traits;

use Solluzi\Interfaces\SQLQueryBuilder;

/**
 * SqlInstructionValues
 *  receives plain sql values to execute
 */
trait SqlInstructionValues
{
    
    /**
     * instructionValues function
     *  receives the values
     * @param string $values
     * @return SQLQueryBuilder
     */
    public function instructionValues($values): SQLQueryBuilder
    {
        /*
        |----------------------------------------------------------------------------------------------
        | type
        |----------------------------------------------------------------------------------------------
        |
        | verifies if requests belong to correct clause (select, call)
        |
        */
        if(!in_array($this->query->type, ['select', 'call']) && empty($values)){
            throw new \Exception("só deve ser adicionado ao SELECT OU CALL para função");
        }
        
        /*
        |----------------------------------------------------------------------------------------------
        | values
        |----------------------------------------------------------------------------------------------
        |
        | store values in a value object
        |
        */
        if(isset($values)) {
            $this->values[] = $values;
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
