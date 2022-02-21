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

namespace Admin\Controllers\Departments;

use Admin\Model\Department;
use Admin\Traits\AclTrait;
use Solluzi\Controller\AbstractController;
use Solluzi\Controller\Form;
use Solluzi\Controller\Request;
use Solluzi\Controller\Traits\HttpStatusCode;
use Solluzi\Psr\Logger\FileLogger;
use Solluzi\Security\Session\Session;

class CreateController extends AbstractController
{
    use AclTrait;

    private $form;
    private $logger;

    /**
     * Class Constructor
     */
    public function __construct()
    {
        $this->isProtected(get_class($this));

        $this->form   = new Form();
        $this->logger = new FileLogger();
    }

    public function process(Request $request)
    {
        try {
            $this->form->setData($request->getPosts());
            $this->form->isValid([
                'name' => ['required' => true, 'max' => '100']
            ]);

            $info = [
                '"NAME"'       => $request->getPost('name')->toString(),
                '"CREATED_BY"' => Session::getValue('user_id'),
                '"CREATED_AT"' => date('Y-m-d H:i:s')
            ];

            $secaoModel  = new Department();
            $secaoInsert = $secaoModel->database('system');
            $secaoInsert
                ->insert($info)
                ->execute();

            //$id = $secaoInsert->getId();

            //$programaModel->adicionarProgramaAoGrupo($formData['grupos'], $id);

            $this->response(HttpStatusCode::CREATED);
        } catch (\Exception $e) {
            $this->logger->emergency($e->getMessage());
            $this->response(HttpStatusCode::NOT_ACCEPTABLE);
        }
    }
}
