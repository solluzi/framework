<?php
declare(strict_types=1);
namespace Model;

use Application\Ado\MySQLQueryBuilder;
use Application\Ado\PostgresQueryBuilder;

abstract class Model
{
    public function start($database)
    {
        
        $dbConfig = require_once dirname(__DIR__,3) . '/config/config.php';
        $type     = $dbConfig[$database]['type'] ?? null;
        
        switch ($type) {
            case 'pgsql':
                return new PostgresQueryBuilder($database, $this->table, $this->primaryKey, $this->idPolicy);
                break;
            
            default:
                return new MySQLQueryBuilder($database, $this->table, $this->primaryKey, $this->idPolicy);
                break;
        }
        
    }
}