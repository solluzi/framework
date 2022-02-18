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
 * Read
 *  Gets and Filter all group informations from table
 */

declare(strict_types=1);

namespace Admin\Controllers\Sections;

use Admin\Model\SystemProgramSection;
use Application\Interface\Middleware;
use Controller\HttpStatusCode;
use Controller\Response;
use Router\Request;
use Traits\PayloadEncryptTrait;

class GetController implements Middleware
{
    use PayloadEncryptTrait;

    public function process(Request $request)
    {
        try {
            // Parametros recebidos do formulário
            $uriParams  = $request->getQueryParams();

            // Model
            $secaoModel = new SystemProgramSection();

            // Campo para filtro
            $filterById       = $uriParams['id'] ?? null;

            $resultados = $secaoModel->database('system')
                ->select('s', ['s."ID" id', 's."NAME" "name"'])
                ->where('"ID"', $filterById)
                ->get();

            // Fomatação de registros
            $resposta['data'] = [
                'record' => $resultados,
            ];

            $payload = $this->encrypt($resposta);

            return Response::json(['data' => $payload], HttpStatusCode::OK);
        } catch (\Exception $e) {
            return Response::json([], HttpStatusCode::BAD_REQUEST);
        }
    }
}
