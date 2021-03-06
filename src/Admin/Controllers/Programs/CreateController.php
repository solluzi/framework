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

namespace Admin\Controllers\Programs;

use Admin\Model\Program;
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
                'department'        => ['required' => true],
                'program'           => ['required' => true],
                'front_identifiyer' => ['required' => true],
                'description'       => ['required' => true],
            ]);

            $info = [
                '"SECTION"'     => $request->getPost('department')->toString(),
                '"PROGRAM"'     => $request->getPost('program')->toString(),
                '"NAME"'        => $request->getPost('front_identifiyer')->toString(),
                '"DESCRIPTION"' => $request->getPost('description')->toString(),
                '"CREATED_BY"'  => Session::getValue('user_id'),
            ];


            $model  = new Program();
            $programaInsert = $model->database('system');
            $programaInsert
                ->insert($info)
                ->execute();

            //$id = $programaInsert->getId();

            //$model->adicionarProgramaAoGrupo($formData['groups'], $id);

            $this->response(HttpStatusCode::CREATED);
        } catch (\Exception $e) {
            $this->logger->emergency($e->getMessage());
            $this->response(HttpStatusCode::NOT_ACCEPTABLE);
        }
    }
}
