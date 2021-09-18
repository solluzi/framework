<?php

/**
 * @version     1.0.0
 * @category    Model
 * @package     App
 * @subpackage  Group
 * @author      Mauro Joaquim Miranda
 * @copyright   Copyright (c) 2020 Solluzi Tecnologia da Informação LTDA-ME. (https://mauromiranda.dev)
 * @license     https://mauromiranda.dev/framework-license
 *
 * SystemGroupProgram
 *  Connects to system_group_program table
 */

declare(strict_types=1);

namespace Admin\Model;

use Model\Model;

class SystemGroupProgram extends Model
{
    protected $table      = '"SYSTEM_GROUP_PROGRAM"';
    protected $primaryKey = '"ID"';
    protected $idPolicy   = "uuid"; // {max, serial, auto, uuid}
}
