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

namespace Admin\Controllers\User;

use Admin\Model\SystemUser;
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
            $usuarioModel      = new SystemUser();
            $usuarioGrupoModel = new SystemUserGroup();


            // Campo para filtro
            $id       = (isset($uriParams['id']) && !empty($uriParams['id'])) ? "{$uriParams['id']}" : null;
            
            ###########################################################################
            ################ BUSCA INFORMAÇÃO DE DADO USUÁRIO PELA ID #################
            ###########################################################################
            $resultados = $usuarioModel->database('system')
                ->select('u', 
                    [
                        'u."ID" id',
                        'u."NAME" "name"', 
                        'u."LOGIN" login', 
                        'u."ACTIVE" status', 
                        'u."PROGRAM_ID" "homePage"'
                    ]
                )
                ->where('"ID"', $id)
                ->get();

            
            
            ###########################################################################
            ################### BUSCA GRUPOS DE DADO USUÁRIO PELA ID ##################
            ###########################################################################
            $resultadoGrupo = $usuarioGrupoModel->database('system')
                ->select('', ['"GROUP_ID" AS id'])
                ->where('"USER_ID"', $id)
                ->getAll();

            $trataResultadoGrupo = [];
            foreach ($resultadoGrupo as $grupo) {
                $trataResultadoGrupo[] = $grupo->id;
            }

            // Fomatação de registros
            $resposta['data'] = [
                'records' => $resultados,
                'groups'    => $trataResultadoGrupo
            ];

            $payload = $this->encrypt($resposta);

            return Response::json(['data' => $payload], HttpStatusCode::OK);
        } catch (\Exception $e) {
            return Response::json([$e->getMessage()], HttpStatusCode::BAD_REQUEST);
        }
    }
}
