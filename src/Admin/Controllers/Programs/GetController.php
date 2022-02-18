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

namespace Admin\Controllers\Programs;

use Admin\Model\SystemGroupProgram;
use Admin\Model\SystemProgram;
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
            $programaModel = new SystemProgram();
            $grupoModel    = new SystemGroupProgram();

            // Campo para filtro
            $id       = (isset($uriParams['id']) && !empty($uriParams['id'])) ? "{$uriParams['id']}" : null;

            $resultados = $programaModel->database('system')
                ->select('p', [
                    'p."ID" id',
                    'p."SECTION" section',
                    'p."NAME" "name"',
                    'p."PROGRAM" "program"',
                    'p."PRIVATE" status',
                    'p."DESCRIPTION" description'
                    ])
                ->where('"ID"', $id, '=')
                ->get();

            // Busca Grupos
            $resultadoGrupos = $grupoModel->database('system')
                ->select('gp', ['gp."GROUP_ID" as id'])
                ->where('gp."PROGRAM_ID"', $id, '=')
                ->getAll();

            $trataGrupo = [];
            foreach ($resultadoGrupos as $grupo) {
                $trataGrupo[] = $grupo->id;
            }

            // Fomatação de registros
            $resposta['data'] = [
                'records' => $resultados,
                'groups'    => $trataGrupo
            ];

            $payload = $this->encrypt($resposta);

            return Response::json(['data' => $payload], HttpStatusCode::OK);
        } catch (\Exception $e) {
            return Response::json([], HttpStatusCode::BAD_REQUEST);
        }
    }
}
