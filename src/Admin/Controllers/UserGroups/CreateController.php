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
 * Create
 *  Create group information in the table
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

class CreateController extends AbstractController
{
    use AclTrait;

    private $form;
    private $logger;

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
            $this->form->isValid([
                'name' => ['required' => true]
            ]);

            $formData  = $request->getPosts();


            $data = [
                '"NAME"'       => $request->getPost('name')->toString(),
                '"CREATED_BY"' => Session::getValue('user'),
                '"CREATED_AT"' => date('Y-m-d H:i:s')
            ];

            $model = new Group();
            $modelInsert = $model->database('system');
            $modelInsert
                ->insert($data)
                ->execute();

            //$model->adicionarGrupoAoPrograma($formData['programs'], $id);
            //$model->adicionarUsuarioAoGrupo($formData['users'], $id);

            $this->response(HttpStatusCode::CREATED);
        } catch (\Exception $e) {
            $this->logger->emergency($e->getMessage());
            $this->response(HttpStatusCode::NOT_ACCEPTABLE);
        }
    }
}
