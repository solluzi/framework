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

namespace Admin\Controllers\UserGroups;

use Admin\Model\SystemGroup;
use Solluzi\Controller\AbstractController;
use Solluzi\Controller\Request;
use Solluzi\Lib\Util\Session\Session;
use Traits\PayloadEncryptTrait;

class CreateController extends AbstractController
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

            $formData  = $request->getPosts();
            
            
            $data = [
                '"NAME"'       => $formData['name'],
                '"CREATED_BY"' => Session::getValue('user'),
                '"CREATED_AT"' => date('Y-m-d H:i:s')
            ];

            $grupoModel = new SystemGroup();
            $grupoModelInsert = $grupoModel->database('system');
            $grupoModelInsert
                ->insert($data)
                ->execute();

            $id = $grupoModelInsert->getId();

            $result['id'] = $id;

            $grupoModel->adicionarGrupoAoPrograma($formData['programs'], $id);
            $grupoModel->adicionarUsuarioAoGrupo($formData['users'], $id);

            $payload = $this->encrypt($result);

            return Response::json(['data' => $payload], HttpStatusCode::CREATED);
        } catch (\Exception $e) {
            return Response::json([$e->getMessage()], HttpStatusCode::BAD_REQUEST);
        }
    }
}
