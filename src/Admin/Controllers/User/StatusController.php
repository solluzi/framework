<?php

/**
 * @version     1.0.0
 * @category    Action
 * @package     App
 * @subpackage  User
 * @author      Mauro Joaquim Miranda
 * @copyright   Copyright (c) 2020 Solluzi Tecnologia da Informação LTDA-ME. (https://mauromiranda.dev)
 * @license     https://mauromiranda.dev/framework-license
 *
 * Status
 *  changes system user status
 */

declare(strict_types=1);

namespace Admin\Controllers\User;

use Admin\Traits\AclTrait;
use Solluzi\Controller\AbstractController;
use Solluzi\Controller\Request;
use Solluzi\Controller\Traits\HttpStatusCode;
use Solluzi\Database\Connection;
use Solluzi\Psr\Logger\FileLogger;

class StatusController extends AbstractController
{
    use AclTrait;

    private $logger;

    public function __construct()
    {
        $this->isProtected(get_class($this));
        $this->logger = new FileLogger();
    }

    public function process(Request $request)
    {
        try {
            // Tratamento de dados
            $conn = Connection::open('system');
            $sql = 'UPDATE "SYSTEM_USER"
                    SET "ACTIVE" = (
                        CASE 
                            WHEN "ACTIVE" IS true THEN false 
                            ELSE true 
                        END)
                    WHERE "ID" = ?;';
            $stmt = $conn->prepare($sql);
            $stmt->execute([$request->getQueryParam('id')]);

            $this->response(HttpStatusCode::RESET_CONTENT);
        } catch (\Exception $e) {
            $this->logger->emergency($e->getMessage());
            $this->response(HttpStatusCode::BAD_REQUEST);
        }
    }
}
