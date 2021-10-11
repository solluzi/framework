<?php
declare(strict_types=1);
namespace Application\Ado\Traits;

use Application\Ado\Connection;

/*
|--------------------------------------------------------------------------
|                                  DbConnecton
|--------------------------------------------------------------------------
|
| Trait to make connection to database
|
*/
trait DbConnection
{
    /*
    |--------------------------------------------------------------------------
    |                                  connect
    |--------------------------------------------------------------------------
    |
    | makes connection to specified database
    |
    */
    
    public function connect()
    {
        $this->conn = Connection::open($this->database);
        return $this->conn;
    }

    /*
    |--------------------------------------------------------------------------
    |                                  open transaction
    |--------------------------------------------------------------------------
    |
    | transaction is important when executing a store procedure
    |
    */
    
    public function beginTransaction(){
        $this->conn->beginTransaction();
    }

    /*
    |--------------------------------------------------------------------------
    |                                  commit
    |--------------------------------------------------------------------------
    |
    | Commit all databases transactions
    |
    */
    public function commit()
    {
        $this->conn->commit();
    }

    /*
    |--------------------------------------------------------------------------
    |                                  close conection
    |--------------------------------------------------------------------------
    |
    | close connection to database
    |
    */
    
    public function close()
    {
        $this->conn = null;
    }

    /*
    |--------------------------------------------------------------------------
    |                                  rollback
    |--------------------------------------------------------------------------
    |
    | called when the sql query displayed an error
    |
    */
    public function rollback()
    {
        $this->conn->rollback();
    }
}