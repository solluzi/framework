<?php

/**
 * @version     1.0.0
 * @category    Model
 * @package     App
 * @subpackage  User
 * @author      Mauro Joaquim Miranda
 * @copyright   Copyright (c) 2020 Solluzi Tecnologia da Informação LTDA-ME. (https://mauromiranda.dev)
 * @license     https://mauromiranda.dev/framework-license
 *
 * SystemAcl
 *  Access control list
 */

declare(strict_types=1);

namespace Admin\Model;

use Solluzi\Database\Model\Model;

class Acl extends Model
{
    protected $table      = '"FN_ISLOGGEDIN"(?) AS acl';
    protected $primaryKey = '"ID"';
    protected $idPolicy   = "uuid"; //{max,serial,auto,uuid}
}
