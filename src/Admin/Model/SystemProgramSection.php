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
 * Programa
 *  Connects to controlador Table
 */

declare(strict_types=1);

namespace Admin\Model;

use Model\Model;

class SystemProgramSection extends Model
{
    public $table      = "system_program_section";
    public $primaryKey = "id";
    public $idPolicy   = "uuid";         //{max,serial,auto,uuid}
}
