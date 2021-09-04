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

namespace Admin\Controllers\SystemProgram;

use Admin\Model\SystemGroupProgram;
use Admin\Model\SystemProgram;
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
            $programaModel = new SystemProgram();
            $grupoModel    = new SystemGroupProgram();

            // Campo para filtro
            $id       = (isset($formData['id']) && !empty($formData['id'])) ? "{$formData['id']}" : null;

            $resultados = $programaModel->start('system')
                ->select('', ['*'])
                ->where('id', $id, '=')
                ->get();

            // Busca Grupos
            $resultadoGrupos = $grupoModel->start('system')
                ->select('', ['grupo as id'])
                ->where('programa', $id, '=')
                ->getAll();

            $trataGrupo = [];
            foreach ($resultadoGrupos as $grupo) {
                $trataGrupo[] = $grupo->id;
            }

            // Fomatação de registros
            $resposta['data'] = [
                'registros' => $resultados,
                'grupos'    => $trataGrupo
            ];

            $payload = $this->encrypt($resposta);

            return Response::json(['data' => $payload], HttpStatusCode::OK);
        } catch (\Exception $e) {
            return Response::json([], HttpStatusCode::BAD_REQUEST);
        }
    }
}
