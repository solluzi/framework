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

namespace Admin\Controllers\SystemUser;

use Application\Interface\Middleware;
use Controller\HttpStatusCode;
use Controller\Response;
use Application\Ado\Connection;
use Router\Request;

class ChangeStatus implements Middleware
{


    public function process(Request $request)
    {
        try {
            $uriParams = $request->getQueryParams();

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
            $stmt->execute([$uriParams['id']]);

            return Response::json([], HttpStatusCode::ACCEPTED);
        } catch (\Exception $e) {
            return Response::json([$e->getMessage()], HttpStatusCode::BAD_REQUEST);
        }
    }
}
