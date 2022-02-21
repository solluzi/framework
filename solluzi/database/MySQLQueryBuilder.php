<?php
declare(strict_types=1);
namespace Solluzi\Database;

use Solluzi\Database\Traits\SqlBetween;
use Solluzi\Database\Traits\SqlDebug;
use Solluzi\Database\Traits\SqlDelete;
use Solluzi\Database\Traits\SqlExecute;
use Solluzi\Database\Traits\SqlGet;
use Solluzi\Database\Traits\SqlGetAll;
use Solluzi\Database\Traits\SqlGetId;
use Solluzi\Database\Traits\SqlGroupBy;
use Solluzi\Database\Traits\SqlHaving;
use Solluzi\Database\Traits\SqlInsert;
use Solluzi\Database\Traits\SqlInstruction;
use Solluzi\Database\Traits\SqlInstructionValues;
use Solluzi\Database\Traits\SqlJoin;
use Solluzi\Database\Traits\SqlLastId;
use Solluzi\Database\Traits\SqlLeftJoin;
use Solluzi\Database\Traits\SqlLimit;
use Solluzi\Database\Traits\SqlNotBetween;
use Solluzi\Database\Traits\SqlOrderBy;
use Solluzi\Database\Traits\SqlOrWhere;
use Solluzi\Database\Traits\SqlRightJoin;
use Solluzi\Database\Traits\SqlSelect;
use Solluzi\Database\Traits\SqlUnion;
use Solluzi\Database\Traits\SqlUnionAll;
use Solluzi\Database\Traits\SqlUpdate;
use Solluzi\Database\Traits\SqlWhere;
use Solluzi\Database\Traits\SqlWhereIn;
use Solluzi\Database\Traits\SqlWhereNotIn;
use Solluzi\Database\Traits\SqlWhereNotNull;
use Solluzi\Database\Traits\SqlWhereNull;
use Solluzi\Interfaces\SQLQueryBuilder;

class MySQLQueryBuilder implements SQLQueryBuilder
{
    protected $database;
    protected $query;
    protected $values = [];
    protected $table;
    protected $primaryKey;
    protected $conn;
    protected $id;
    public $idPolicy;
    
    use SqlSelect;
    use SqlInsert;
    use SqlUpdate;
    use SqlDelete;
    use SqlJoin;
    use SqlLeftJoin;
    use SqlRightJoin;
    use SqlUnion;
    use SqlUnionAll;
    use SqlWhere;
    use SqlOrWhere;
    use SqlWhereIn;
    use SqlWhereNotIn;
    use SqlWhereNull;
    use SqlWhereNotNull;
    use SqlHaving;
    use SqlOrderBy;
    use SqlGroupBy;
    use SqlLimit;
    use SqlGet;
    use SqlGetAll;
    use SqlExecute;
    use SqlDebug;
    use SqlLastId;
    use SqlGetId;
    use SqlBetween;
    use SqlInstruction;
    use SqlInstructionValues;
    use SqlNotBetween;


    public function __construct($database, $table, $primaryKey, $idPolicy)
    {
        $this->database   = $database;
        $this->table      = $table;
        $this->primaryKey = $primaryKey;
        $this->idPolicy   = $idPolicy;
    }

    protected function reset(): void
    {
        $this->query = new \stdClass;
    }

}
