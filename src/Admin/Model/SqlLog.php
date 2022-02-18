<?php

/**
 * @version     1.0.0
 * @category    Model
 * @package     App
 * @subpackage  Log
 * @author      Mauro Joaquim Miranda
 * @copyright   Copyright (c) 2020 Solluzi Tecnologia da Informação LTDA-ME. (https://mauromiranda.dev)
 * @license     https://mauromiranda.dev/framework-license
 *
 * SystemSQLLog
 *  connects to vw_sql_log sql view script
 */

declare(strict_types=1);

namespace Admin\Model;

use Solluzi\Database\Model\Model;

class SqlLog extends Model
{
    protected $table      = '"SYSTEM_SQL_LOG"';
    protected $primaryKey = '"ID"';
    protected $idPolicy   = "uuid"; // {max, serial, auto, uuid}
}
