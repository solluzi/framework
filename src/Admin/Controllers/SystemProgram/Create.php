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

namespace Admin\Controllers\SystemProgram;

use Admin\Model\SystemProgram;
use Application\Interface\Middleware;
use Controller\HttpStatusCode;
use Controller\Response;
use Form\Form;
use Router\Request;
use Session\Session;
use Traits\PayloadEncryptTrait;

class Create implements Middleware
{
    use PayloadEncryptTrait;

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
                'name' => ['required' => true]
            ]);

            $formData = $request->getBody();

            $info = [
                '"SECTION"'     => $formData['section'],
                '"PROGRAM"'     => $formData['program'],
                '"NAME"'        => $formData['name'],
                '"PRIVATE"'     => $formData['private'] == 1 ? 1 : 0,
                '"DESCRIPTION"' => $formData['description'],
                '"CREATED_BY"'    => Session::getValue('user'),
            ];


            $programaModel  = new SystemProgram();
            $programaInsert = $programaModel->database('system');
            $programaInsert
                ->insert($info)
                ->execute();

            $id = $programaInsert->getId();

            $programaModel->adicionarProgramaAoGrupo($formData['groups'], $id);

            $result['id'] = $id;

            $payload      = $this->encrypt($result);

            return Response::json(['data' => $payload], HttpStatusCode::CREATED);
        } catch (\Exception $e) {
            return Response::json([$e->getMessage()], HttpStatusCode::BAD_REQUEST);
        }
    }
}
