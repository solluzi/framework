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

namespace Admin\Controllers\UserProfile;

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
                    'nome' => ['required' => true]
                ]
            );

            $formData  = $request->getBody();
            $uriParams = $request->getQueryParams();

            // Dados de informação
            $info = [
                'secao'      => $formData['secao'],
                'icone'      => $formData['icone'],
                'url'        => $formData['url'],
                'programa'   => $formData['namespace'],
                'nome'       => $formData['nome'],
                'privado'    => $formData['nivel_acesso'],
                'descricao'  => $formData['descricao'],
                'updated_by' => Session::getValue('user'),
                'updated_at' => date('Y-m-d H:i:s')
            ];


            $usuarioModel     = new SystemUser();
            $usuarioUpdate = $usuarioModel->start('system');
            $usuarioUpdate->update($info)
                ->where('id', $uriParams['id'])
                ->execute();

                // Insere novos grupos
            //$programaModel->adicionarProgramaAoGrupo($formData['grupos'], $uriParams['id']);

            $result['id'] = $uriParams['id'];

            Response::json($result, HttpStatusCode::CREATED);
        } catch (\Exception $e) {
            Response::json([], HttpStatusCode::NOT_ACCEPTABLE);
        }
    }
}
