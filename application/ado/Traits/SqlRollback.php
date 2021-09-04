<?php
declare(strict_types=1);
namespace Application\Ado\Traits;

/**
 * 
 */
trait SqlRollback
{
    /**
     * rollback function
     *  undone all executed queries
     * 
     * @return void
     */
    public function rollback()
    {
        /*
        |----------------------------------------------------------------------------------------------
        | rollback
        |----------------------------------------------------------------------------------------------
        |
        | get executed sql and undone it
        |
        */
        $this->conn->rollback();
    }
}
