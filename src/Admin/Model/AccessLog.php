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
 * SystemAccessLog
 *  Connects to table
 */

declare(strict_types=1);

namespace Admin\Model;

use Solluzi\Database\Model\Model;

class SystemAccessLog extends Model
{
    protected $table      = '"SYSTEM_ACCESS_LOG"';
    protected $primaryKey = '"ID"';
    protected $idPolicy   = "uuid"; //{auto,serial,uuid}
}
