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
            /* $this->form->validate(
                [
                    'nome' => ['required' => true]
                ]
            ); */

            $formData  = $request->getBody();

            $uriParams = $request->getQueryParams();

            #######################################################################
            ######################## ATUALIZAR NOME DO GRUPO ######################
            #######################################################################
            $campos = [
                'nome'       => $formData['nome'],
                'updated_by' => Session::getValue('user'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
            $id         = $uriParams['id'];
            $grupoModel = new SystemGroup();
            $grupoModel->start('system')
                ->update($campos)
                ->where('id', $id)
                ->execute();

            #######################################################################
            ######################## ATUALIZAR PERMISSÕES #########################
            #######################################################################
            $grupoModel->adicionarGrupoAoPrograma($formData['programas'], $id);



            #######################################################################
            #################### ATUALIZAR USUÁRIOS & GRUPOS ######################
            #######################################################################

            $grupoModel->adicionarUsuarioAoGrupo($formData['usuarios'], $id);

            $payload = $this->encrypt($id);

            return Response::json(['data' => $payload], HttpStatusCode::OK);
        } catch (\Exception $e) {
            Response::json([], HttpStatusCode::BAD_REQUEST);
        }
    }
}
