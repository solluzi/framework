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
 * SystemGroup
 *  Connects to system_group Table
 */

declare(strict_types=1);

namespace Admin\Model;

use Solluzi\Database\Model\Model;

class Group extends Model
{
    protected $table      = '"SYSTEM_GROUP"';
    protected $primaryKey = '"ID"';
    protected $idPolicy   = "uuid"; // {max, serial, auto, uuid}
}
