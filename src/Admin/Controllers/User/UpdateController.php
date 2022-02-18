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
 *  updates system user information
 */

declare(strict_types=1);

namespace Admin\Controllers\User;

use Admin\Model\SystemUser;
use Application\Interface\Middleware;
use Controller\HttpStatusCode;
use Controller\Response;
use Form\Form;
use Router\Request;
use Session\Session;

class UpdateController implements Middleware
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
                    'login' => ['required' => true]
                ]
            );

            $formData  = $request->getBody();
            $uriParams = $request->getQueryParams();

            // Tratamento de Campos

            $senha = $formData['senha'] ?? null;
            //$ativo = ($formData['ativo'] == 'false') ? 0 : 1;

            $info = [
                '"LOGIN"'      => $formData['login'],
                //'senha'      => BCrypt::hash($senha),
                '"ACTIVE"'     => $formData['active'] ?? false,
                '"NAME"'       => $formData['name'],
                '"PROGRAM_ID"' => $formData['program'],
                '"UPDATED_BY"' => Session::getValue('user')
            ];

            if (isset($formData['senha']) && empty($formData['senha'])) :
                unset($info['senha']);
            endif;


            // Atualiza os dados
            $usuarioModel = new SystemUser();
            $usuarioModel->database('system')
                ->update($info)
                ->where('"ID"', $uriParams['id'])
                ->execute();

            // Atualiza os grupos
            $grupos = (object)$formData['groups'];
            $usuarioModel->inserirGrupoAoUsuario($grupos, $uriParams['id']);

            $result['id'] = $uriParams['id'];

            Response::json($result, HttpStatusCode::CREATED);
        } catch (\Exception $e) {
            Response::json([$e->getMessage()], HttpStatusCode::BAD_REQUEST);
        }
    }
}
