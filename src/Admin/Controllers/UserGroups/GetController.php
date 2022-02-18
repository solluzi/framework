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

namespace Admin\Controllers\UserGroups;

use Admin\Model\SystemGroup;
use Admin\Model\SystemGroupProgram;
use Admin\Model\SystemUserGroup;
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
            $grupoModel         = new SystemGroup();
            $programaGrupoModel = new SystemGroupProgram();
            $usuarioGrupoModel  = new SystemUserGroup();


            // Campo para filtro
            $filterById       = $uriParams['id'] ?? null;

            $resultados = $grupoModel->database('system')
                ->select('g', ['g."ID" id', 'g."NAME" "name"'])
                ->where('"ID"', $filterById, '=')
                ->get();

            // Buscar Programas
            $resultadoProgramas = $programaGrupoModel->database('system')
                ->select('gp', ['gp."PROGRAM_ID" id'])
                ->where('"GROUP_ID"', $filterById)
                ->getAll();

            $trataProgramas = [];
            foreach ($resultadoProgramas as $programas) {
                $trataProgramas[] = $programas->id;
            }

            // Buscar Usuarios
            $resultadoUsuarios = $usuarioGrupoModel->database('system')
                ->select('ug', ['ug."USER_ID" id'])
                ->where('ug."GROUP_ID"', $filterById)
                ->getAll();

            $trataUsuarios = [];
            foreach ($resultadoUsuarios as $usuarios) {
                $trataUsuarios[] = $usuarios->id;
            }


            // Fomatação de registros
            $resposta['data'] = [
                'records'  => $resultados,
                'programs' => $trataProgramas,
                'users'    => $trataUsuarios
            ];

            $payload = $this->encrypt($resposta);

            return Response::json(['data' => $payload], HttpStatusCode::OK);
        } catch (\Exception $e) {
            return Response::json([], HttpStatusCode::BAD_REQUEST);
        }
    }
}
