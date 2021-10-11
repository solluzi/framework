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

namespace Admin\Controllers\SystemGroup;

use Admin\Model\SystemGroup;
use Admin\Model\SystemGroupProgram;
use Admin\Model\SystemUserGroup;
use Application\Interface\Middleware;
use Controller\HttpStatusCode;
use Controller\Response;
use Router\Request;
use Traits\PayloadEncryptTrait;

class Edit implements Middleware
{
    use PayloadEncryptTrait;


    public function process(Request $request)
    {
        try {
            // Parametros recebidos do formulário
            $formData  = $request->getBody();

            // Model
            $grupoModel         = new SystemGroup();
            $programaGrupoModel = new SystemGroupProgram();
            $usuarioGrupoModel  = new SystemUserGroup();


            // Campo para filtro
            $id       = (isset($formData['id']) && !empty($formData['id'])) ? "{$formData['id']}" : null;

            $resultados = $grupoModel->database('system')
                ->select('', ['*'])
                ->where('id', $id, '=')
                ->get();

            // Buscar Programas
            $resultadoProgramas = $programaGrupoModel->database('system')
                ->select('', ['programa as id'])
                ->where('grupo', $id, '=')
                ->getAll();

            $trataProgramas = [];
            foreach ($resultadoProgramas as $programas) {
                $trataProgramas[] = $programas->id;
            }

            // Buscar Usuarios
            $resultadoUsuarios = $usuarioGrupoModel->database('system')
                ->select('', ['usuario as id'])
                ->where('grupo', $id, '=')
                ->getAll();

            $trataUsuarios = [];
            foreach ($resultadoUsuarios as $usuarios) {
                $trataUsuarios[] = $usuarios->id;
            }


            // Fomatação de registros
            $resposta['data'] = [
                'registros' => $resultados,
                'programas' => $trataProgramas,
                'usuarios'  => $trataUsuarios
            ];

            $payload = $this->encrypt($resposta);

            return Response::json(['data' => $payload], HttpStatusCode::OK);
        } catch (\Exception $e) {
            return Response::json([], HttpStatusCode::BAD_REQUEST);
        }
    }
}
