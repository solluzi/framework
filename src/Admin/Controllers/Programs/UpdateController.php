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

namespace Admin\Controllers\Programs;

use Admin\Model\SystemProgram;
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
                    'name' => ['required' => true]
                ]
            );

            $formData  = $request->getBody();
            $uriParams = $request->getQueryParams();
//print_r($formData);die;

            // Dados de informação
            $info = [
                '"SECTION"'     => $formData['section'],
                '"PROGRAM"'     => $formData['program'],
                '"NAME"'        => $formData['name'],
                '"PRIVATE"'     => $formData['private'] ?? 0,
                '"DESCRIPTION"' => $formData['description'],
                '"UPDATED_BY"'  => Session::getValue('user'),
                '"UPDATED_AT"'  => date('Y-m-d H:i:s')
            ];


            $programaModel     = new SystemProgram();
            $programaUpdate = $programaModel->database('system');
            $programaUpdate->update($info)
                ->where('"ID"', $uriParams['id'])
                ->execute();
            
                // Insere novos grupos
            $programaModel->adicionarProgramaAoGrupo($formData['groups'], $uriParams['id']);

            $result['id'] = $uriParams['id'];

            Response::json($result, HttpStatusCode::CREATED);
        } catch (\Exception $e) {
            Response::json([$e->getMessage()], HttpStatusCode::NOT_ACCEPTABLE);
        }
    }
}
