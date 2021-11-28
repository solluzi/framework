<?php

/**
 * @version     1.0.0
 * @category    Model
 * @package     App
 * @subpackage  System
 * @author      Mauro Joaquim Miranda
 * @copyright   Copyright (c) 2020 Solluzi Tecnologia da Informação LTDA-ME. (https://mauromiranda.dev)
 * @license     https://mauromiranda.dev/framework-license
 *
 * SystemConfiguration
 *  Conects to system_configuration table
 */

declare(strict_types=1);

namespace Admin\Model;

use Model\Model;

class SystemConfiguration extends Model
{
    protected $table      = '"SYSTEM_CONFIGURATION"';
    protected $primaryKey = 'id';
    protected $idPolicy   = "uuid"; // {max, serial, auto, uuid}
}
