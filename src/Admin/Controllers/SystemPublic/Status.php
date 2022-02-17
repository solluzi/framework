<?php

/**
 * @version     1.0.0
 * @category    Action
 * @package     App
 * @subpackage  General
 * @author      Mauro Joaquim Miranda
 * @copyright   Copyright (c) 2020 Solluzi Tecnologia da Informação LTDA-ME. (https://mauromiranda.dev)
 * @license     https://mauromiranda.dev/framework-license
 *
 * SystemStatus
 *  Verifies if the system is online
 *
 * @OA\Info(title="API Base de Sistemas", version="0.1")
 */

declare(strict_types=1);

namespace Admin\Controllers\SystemPublic;

use Solluzi\Controller\AbstractController;
use Solluzi\Controller\Request;
use Solluzi\Psr\Logger\FileLogger;

class Status extends AbstractController
{
    private $logger;

    public function __construct()
    {
        $this->logger = new FileLogger;
    }
    public function process(Request $request)
    {
        $this->response(200, ['time' => time()]);
    }
}
