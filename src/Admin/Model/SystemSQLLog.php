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

use Model\Model;

class SystemSQLLog extends Model
{
    protected $table      = "system_sql_log";
    protected $primaryKey = "id";
    protected $idPolicy   = "uuid"; // {max, serial, auto, uuid}
}
