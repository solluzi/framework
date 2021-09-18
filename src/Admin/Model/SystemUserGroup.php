<?php

/**
 * @version     1.0.0
 * @category    Model
 * @package     App
 * @subpackage  Program
 * @author      Mauro Joaquim Miranda
 * @copyright   Copyright (c) 2020 Solluzi Tecnologia da Informação LTDA-ME. (https://mauromiranda.dev)
 * @license     https://mauromiranda.dev/framework-license
 *
 * SystemProgram
 *  connects to system_program table
 */

declare(strict_types=1);

namespace Admin\Model;

use Model\Model;

class SystemUserGroup extends Model
{
    protected $table      = '"SYSTEM_USER_GROUP"';
    protected $primaryKey = '"ID"';
    protected $idPolicy   = "uuid"; // {max, auto, serial, uuid}
}
