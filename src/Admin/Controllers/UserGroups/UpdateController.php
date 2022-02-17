<?php

/**
 * @version     1.0.0
 * @category    Action
 * @package     App
 * @subpackage  General
 * @author      Mauro Joaquim Miranda
 * @copyright   Copyright (c) 2020 Solluzi Tecnologia da Informação LTDA-ME. (https://mauromiranda.dev)
 * @license     https://mauromiranda.dev/framework-license
 *
 * Update
 *  updates current group information in the table
 */

declare(strict_types=1);

namespace Admin\Controllers\SystemGroup;

use Admin\Model\SystemGroup;
use Application\Interface\Middleware;
use Controller\HttpStatusCode;
use Controller\Response;
use Form\Form;
use Administracao\Model\Grupo;
use Router\Request;
use Session\Session;
use Traits\PayloadEncryptTrait;

class Update implements Middleware
{
    use PayloadEncryptTrait;

    private $form;

    /**
     * Class Constructor
     */
    public function __construct()
    {
        $this->form = new Form();
    }


    public function process(Request $request)
    {
        try {
            $this->form->validate(
                [
                    'name' => ['required' => true]
                ]
            ); 

            $formData  = $request->getBody();

            $uriParams = $request->getQueryParams();
            
            #######################################################################
            ######################## ATUALIZAR NOME DO GRUPO ######################
            #######################################################################
            $campos = [
                '"NAME"'       => $formData['name'],
                '"UPDATED_BY"' => Session::getValue('user'),
                '"UPDATED_AT"' => date('Y-m-d H:i:s')
            ];
            $id         = $uriParams['id'];
            $grupoModel = new SystemGroup();
            $grupoModel->database('system')
                ->update($campos)
                ->where('"ID"', $id)
                ->execute();


            #######################################################################
            ######################## ATUALIZAR PERMISSÕES #########################
            #######################################################################
            $grupoModel->adicionarGrupoAoPrograma($formData['programs'], $id);



            #######################################################################
            #################### ATUALIZAR USUÁRIOS & GRUPOS ######################
            #######################################################################

            $grupoModel->adicionarUsuarioAoGrupo($formData['users'], $id);

            $payload = $this->encrypt($id);

            return Response::json(['data' => $payload], HttpStatusCode::OK);
        } catch (\Exception $e) {
            Response::json([], HttpStatusCode::BAD_REQUEST);
        }
    }
}
