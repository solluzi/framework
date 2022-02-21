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

namespace Admin\Controllers\UserGroups;

use Admin\Model\Group;
use Admin\Traits\AclTrait;
use Solluzi\Controller\AbstractController;
use Solluzi\Controller\Form;
use Solluzi\Controller\Request;
use Solluzi\Controller\Traits\HttpStatusCode;
use Solluzi\Psr\Logger\FileLogger;
use Solluzi\Security\Session\Session;

class UpdateController extends AbstractController
{
    use AclTrait;

    private $form;
    private $logger;

    /**
     * Class Constructor
     */
    public function __construct()
    {
        $this->isProtected(get_class($this));

        $this->form   = new Form();
        $this->logger = new FileLogger();
    }


    public function process(Request $request)
    {
        try {
            $this->form->setData($request->getPosts());
            $this->form->isValid(
                [
                    'name' => ['required' => true]
                ]
            );

            #######################################################################
            ######################## ATUALIZAR NOME DO GRUPO ######################
            #######################################################################
            $fields = [
                '"NAME"'       => $request->getPost('name')->toString(),
                '"UPDATED_BY"' => Session::getValue('user_id'),
                '"UPDATED_AT"' => date('Y-m-d H:i:s')
            ];
            $id         = $request->getQueryParam('id');
            $model = new Group();
            $model->database('system')
                ->update($fields)
                ->where('"ID"', $id)
                ->execute();


            #######################################################################
            ######################## ATUALIZAR PERMISSÕES #########################
            #######################################################################
            //$model->adicionarGrupoAoPrograma($formData['programs'], $id);



            #######################################################################
            #################### ATUALIZAR USUÁRIOS & GRUPOS ######################
            #######################################################################

            //$model->adicionarUsuarioAoGrupo($formData['users'], $id);

            $this->response(HttpStatusCode::CREATED);
        } catch (\Exception $e) {
            $this->logger->emergency($e->getMessage());
            $this->response(HttpStatusCode::NOT_ACCEPTABLE);
        }
    }
}
