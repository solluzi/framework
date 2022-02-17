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

namespace Admin\Controllers\SystemSection;

use Admin\Model\SystemProgramSection;
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
                    'name' => ['required' => true]
                ]
            );

            $formData  = $request->getBody();
            $uriParams = $request->getQueryParams();

            // Dados de informação
            $info = [
                '"NAME"'       => $formData['name'],
                '"UPDATED_BY"'  => Session::getValue('user'),
                '"UPDATED_AT"'  => date('Y-m-d H:i:s')
            ];

            $secaoModel     = new SystemProgramSection();
            $secaoModel->database('system')
                ->update($info)
                ->where('"ID"', $uriParams['id'])
                ->execute();

                // Insere novos grupos
            //$programaModel->adicionarProgramaAoGrupo($formData['grupos'], $uriParams['id']);

            $result['id'] = $uriParams['id'];

            Response::json($result, HttpStatusCode::CREATED);
        } catch (\Exception $e) {
            Response::json([], HttpStatusCode::BAD_REQUEST);
        }
    }
}
