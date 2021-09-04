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
                'nome' => ['required' => true, 'max' => '100']
            ]);

            $formData = $request->getBody();

            $info = [
                'secao'      => $formData['secao'],
                'icone'      => $formData['icone'],
                'url'        => $formData['url'],
                'programa'   => $formData['namespace'],
                'nome'       => $formData['nome'],
                'privado'    => $formData['nivel_acesso'],
                'descricao'  => $formData['descricao'],
                'created_by' => Session::getValue('user'),
                'created_at' => date('Y-m-d H:i:s')
            ];


            $programaModel  = new SystemProgram();
            $programaInsert = $programaModel->start('system');
            $programaInsert
                ->insert($info)
                ->execute();

            $id = $programaInsert->getId();

            $programaModel->adicionarProgramaAoGrupo($formData['grupos'], $id);

            $result['id'] = $id;

            $payload      = $this->encrypt($result);

            return Response::json(['data' => $payload], HttpStatusCode::CREATED);
        } catch (\Exception $e) {
            return Response::json([$e->getMessage()], HttpStatusCode::BAD_REQUEST);
        }
    }
}
