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
 * Delete
 *  deletes system user information
 */

declare(strict_types=1);

namespace Admin\Controllers\SystemUser;

use Admin\Model\SystemUser;
use Application\Interface\Middleware;
use Controller\HttpStatusCode;
use Controller\Response;
use Router\Request;

class Delete implements Middleware
{


    public function process(Request $request)
    {
        try {
            $uriParams = $request->getQueryParams();

            // Remove o usuário
            $usuarioModel = new SystemUser();
            $usuarioModel->database('system')
                ->delete()
                ->where('id', $uriParams['id'])
                ->execute();

            return Response::json([], HttpStatusCode::RESET_CONTENT);
        } catch (\Exception $e) {
            return Response::json([], HttpStatusCode::BAD_REQUEST);
        }
    }
}
