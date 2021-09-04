<?php
declare(strict_types=1);
namespace Application\Ado\Traits;

use Application\Ado\Connection;

/**
 * 
 */
trait DbConnection
{

    public function connect()
    {
        $this->conn = Connection::open($this->database);
        return $this->conn;
    }

    public function dbClose()
    {
        $this->conn = null;
    }

    public function taskRollback()
    {
        $this->conn->rollback();
    }
}