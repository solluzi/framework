<?php

/**
 * @version     1.0.0
 * @category    Action
 * @package     App
 * @subpackage  Group
 * @author      Mauro Joaquim Miranda
 * @copyright   Copyright (c) 2020 Solluzi Tecnologia da Informação LTDA-ME. (https://mauromiranda.dev)
 * @license     https://mauromiranda.dev/framework-license
 *
 * Delete
 *  Exclude group information from table
 */

declare(strict_types=1);

namespace Admin\Controllers\Programs;

use Admin\Model\SystemProgram;
use Application\Interface\Middleware;
use Controller\HttpStatusCode;
use Controller\Response;
use Router\Request;

class DeleteController implements Middleware
{

    public function process(Request $request)
    {
        try {
            $uriParams = $request->getQueryParams();

            $programaModel = new SystemProgram();
            $programaModel->database('system')
                ->delete()
                ->where('"ID"', $uriParams['id'])
                ->execute();

            return Response::json([], HttpStatusCode::RESET_CONTENT);
        } catch (\Exception $e) {
            return Response::json(['errors' => 'Erro'], HttpStatusCode::BAD_REQUEST);
        }
    }
}
