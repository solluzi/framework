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

namespace Admin\Controllers\SystemSection;

use Admin\Model\SystemProgramSection;
use Application\Interface\Middleware;
use Controller\HttpStatusCode;
use Controller\Response;
use Form\Form;
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
            $this->form->validate([
                'nome' => ['required' => true, 'max' => '100']
            ]);

            $formData = $request->getBody();

            $info = [
                'nome'       => $formData['nome'],
                'created_by' => Session::getValue('user'),
                'created_at' => date('Y-m-d H:i:s')
            ];

            $secaoModel  = new SystemProgramSection();
            $secaoInsert = $secaoModel->database('system');
            $secaoInsert
                ->insert($info)
                ->execute();

            $id = $secaoInsert->getId();

            //$programaModel->adicionarProgramaAoGrupo($formData['grupos'], $id);

            $result['id'] = $id;
            return Response::json(['data' => $result], HttpStatusCode::CREATED);
        } catch (\Exception $e) {
            return Response::json([$e->getMessage()], HttpStatusCode::BAD_REQUEST);
        }
    }
}
