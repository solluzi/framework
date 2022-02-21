<?php

/**
 * @version     1.0.0
 * @category    Action
 * @package     App
 * @subpackage  User
 * @author      Mauro Joaquim Miranda
 * @copyright   Copyright (c) 2020 Solluzi Tecnologia da Informação LTDA-ME. (https://mauromiranda.dev)
 * @license     https://mauromiranda.dev/framework-license
 *
 * Create
 *  creates system user information
 */

declare(strict_types=1);

namespace Admin\Controllers\User;

use Admin\Model\User;
use Admin\Traits\AclTrait;
use Solluzi\Controller\AbstractController;
use Solluzi\Controller\Form;
use Solluzi\Controller\Request;
use Solluzi\Controller\Traits\HttpStatusCode;
use Solluzi\Controller\Traits\PayloadEncryptTrait;
use Solluzi\Helper\BCrypt;
use Solluzi\Psr\Logger\FileLogger;
use Solluzi\Security\Session\Session;

class CreateController extends AbstractController
{
    use PayloadEncryptTrait;
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
            $this->form->isValid(
                [
                    'register' => ['required' => true],
                    'username' => ['required' => true],
                    'page'     => ['required' => true],
                ]
            );

            $password    = BCrypt::senha(12, true, true, true, true);

            // Trata campos do formulários
            $info = [
                '"NAME"'       => 'Ser Teste',
                '"LOGIN"'      => $request->getPost('username')->toString(),
                '"PASSWORD"'   => BCrypt::hash($password),
                '"ACTIVE"'     => $request->getPost('ative')->toBoolean(),
                //'"REGISTER"'     => $request->getPost('register')->toString(),
                '"PROGRAM_ID"' => $request->getPost('page')->toString(),
                '"CREATED_BY"' => Session::getValue('user_id')
            ];

            // Cadastra a informação
            $userModel  = new User();
            $userInsert = $userModel->database('system');
            $userInsert->insert($info)->execute();

            /**
            *--------------------------------------------------------------------------
            *                       Send E-mail
            *--------------------------------------------------------------------------
            *
            *
            *
            */


            /* $id = $userInsert->getId();
            $grupos = (object)$formData['grupos'];
            $userModel->inserirGrupoAoUsuario($grupos, $id);

            $result['id'] = $id; */

            $this->response(HttpStatusCode::CREATED);
        } catch (\Exception $e) {
            $this->logger->emergency($e->getMessage());
            $this->response(HttpStatusCode::NOT_ACCEPTABLE);
        }
    }
}
