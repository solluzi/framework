<?php

/**
 * @version     1.0.0
 * @category    Model
 * @package     App
 * @subpackage  General
 * @author      Mauro Joaquim Miranda
 * @copyright   Copyright (c) 2020 Solluzi Tecnologia da Informação LTDA-ME. (https://mauromiranda.dev)
 * @license     https://mauromiranda.dev/framework-license
 *
 * SystemSignIn
 *  connects to system_user table for signin
 */

declare(strict_types=1);

namespace Admin\Model;

use Model\Model;

class SystemLogin extends Model
{
    protected $table           = "fn_login(?)";
    protected $primaryKey      = "id";
    protected $idPolicy        = "uuid"; // {max, serial, auto, uuid}
}
