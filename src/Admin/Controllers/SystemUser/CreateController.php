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

namespace Admin\Controllers\SystemUser;

use Admin\Model\SystemUser;
use Application\Interface\Middleware;
use Controller\HttpStatusCode;
use Controller\Response;
use Form\Form;
use General\BCrypt;
use Router\Request;
use Session\Session;

class Create implements Middleware
{

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
                    'login'    => ['required' => true],
                    //'pass'     => ['required' => true],
                    'pessoa' => ['required' => true],
                ]
            );

            $formData = $request->getBody();
            $senha    = BCrypt::senha(12, true, true, true, true);

            // Trata campos do formulários
            $info = [
                'login'      => $formData['login'],
                'senha'      => BCrypt::hash($senha),
                'ativo'      => $formData['ativo'],
                'pessoa'     => $formData['pessoa'],
                'entrada'    => $formData['entrada'],
                'created_by' => Session::getValue('user')
            ];

            // Cadastra a informação
            $usuarioModel  = new SystemUser();
            $usuarioInsert = $usuarioModel->database('system');
            $usuarioInsert->insert($info)->execute();


            $id = $usuarioInsert->getId();
            $grupos = (object)$formData['grupos'];
            $usuarioModel->inserirGrupoAoUsuario($grupos, $id);

            $result['id'] = $id;

            Response::json(['data' => $result], HttpStatusCode::CREATED);
        } catch (\Exception $e) {
            Response::json([$e->getMessage()], HttpStatusCode::BAD_REQUEST);
        }
    }
}
