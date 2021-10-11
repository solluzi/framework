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

namespace Admin\Controllers\SystemUser;

use Admin\Model\SystemUser;
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
            $usuarioModel      = new SystemUser();
            $usuarioGrupoModel = new SystemUserGroup();


            // Campo para filtro
            $id       = (isset($formData['id']) && !empty($formData['id'])) ? "{$formData['id']}" : null;

            ###########################################################################
            ################ BUSCA INFORMAÇÃO DE DADO USUÁRIO PELA ID #################
            ###########################################################################
            $resultados = $usuarioModel->database('system')
                ->select('', ['*'])
                ->where('id', $id)
                ->get();


            ###########################################################################
            ################### BUSCA GRUPOS DE DADO USUÁRIO PELA ID ##################
            ###########################################################################
            $resultadoGrupo = $usuarioGrupoModel->database('system')
                ->select('', ['grupo AS id'])
                ->where('usuario', $id)
                ->getAll();

            $trataResultadoGrupo = [];
            foreach ($resultadoGrupo as $grupo) {
                $trataResultadoGrupo[] = $grupo->id;
            }

            // Fomatação de registros
            $resposta['data'] = [
                'registros' => $resultados,
                'grupos'    => $trataResultadoGrupo
            ];

            $payload = $this->encrypt($resposta);

            return Response::json(['data' => $payload], HttpStatusCode::OK);
        } catch (\Exception $e) {
            return Response::json([], HttpStatusCode::BAD_REQUEST);
        }
    }
}
