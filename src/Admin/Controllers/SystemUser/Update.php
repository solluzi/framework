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

namespace Admin\Controllers\SystemUser;

use Admin\Model\SystemUser;
use Application\Interface\Middleware;
use Controller\HttpStatusCode;
use Controller\Response;
use Form\Form;
use Router\Request;
use Session\Session;

class Update implements Middleware
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
            $ativo = ($formData['ativo'] == 'false') ? 0 : 1;

            $info = [
                'login'      => $formData['login'],
                //'senha'      => BCrypt::hash($senha),
                'ativo'      => $ativo,
                'pessoa'     => $formData['pessoa'],
                'entrada'    => $formData['entrada'],
                'updated_by' => Session::getValue('user')
            ];

            if (isset($formData['senha']) && empty($formData['senha'])) :
                unset($info['senha']);
            endif;


            // Atualiza os dados
            $usuarioModel = new SystemUser();
            $usuarioModel->database('system')
                ->update($info)
                ->where('id', $uriParams['id'])
                ->execute();

            // Atualiza os grupos
            $grupos = (object)$formData['grupos'];
            $usuarioModel->inserirGrupoAoUsuario($grupos, $uriParams['id']);

            $result['id'] = $uriParams['id'];

            Response::json($result, HttpStatusCode::CREATED);
        } catch (\Exception $e) {
            Response::json([$e->getMessage()], HttpStatusCode::BAD_REQUEST);
        }
    }
}
