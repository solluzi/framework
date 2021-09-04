<?php
declare(strict_types=1);
namespace Application\Ado;

use Application\Ado\Traits\SqlBetween;
use Application\Ado\Traits\SqlDebug;
use Application\Ado\Traits\SqlDelete;
use Application\Ado\Traits\SqlExecute;
use Application\Ado\Traits\SqlGet;
use Application\Ado\Traits\SqlGetAll;
use Application\Ado\Traits\SqlGetId;
use Application\Ado\Traits\SqlGroupBy;
use Application\Ado\Traits\SqlHaving;
use Application\Ado\Traits\SqlInsert;
use Application\Ado\Traits\SqlInstruction;
use Application\Ado\Traits\SqlInstructionValues;
use Application\Ado\Traits\SqlJoin;
use Application\Ado\Traits\SqlLeftJoin;
use Application\Ado\Traits\SqlLimit;
use Application\Ado\Traits\SqlNotBetween;
use Application\Ado\Traits\SqlOrderBy;
use Application\Ado\Traits\SqlOrWhere;
use Application\Ado\Traits\SqlRightJoin;
use Application\Ado\Traits\SqlSelect;
use Application\Ado\Traits\SqlUnion;
use Application\Ado\Traits\SqlUnionAll;
use Application\Ado\Traits\SqlUpdate;
use Application\Ado\Traits\SqlWhere;
use Application\Ado\Traits\SqlWhereIn;
use Application\Ado\Traits\SqlWhereNotIn;
use Application\Ado\Traits\SqlWhereNotNull;
use Application\Ado\Traits\SqlWhereNull;
use Application\Interface\SQLQueryBuilder;

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
