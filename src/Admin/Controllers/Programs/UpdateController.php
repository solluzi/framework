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

use Admin\Model\Program;
use Admin\Traits\AclTrait;
use Solluzi\Controller\AbstractController;
use Solluzi\Controller\Form;
use Solluzi\Controller\Request;
use Solluzi\Controller\Traits\HttpStatusCode;
use Solluzi\Psr\Logger\FileLogger;
use Solluzi\Security\Session\Session;

class UpdateController extends AbstractController
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

        $this->form = new Form();
        $this->logger = new FileLogger();
    }


    public function process(Request $request)
    {
        try {
            $this->form->setData($request->getPosts());
            $this->form->isValid(
                [
                    'department'        => ['required' => true],
                    'program'           => ['required' => true],
                    'front_identifiyer' => ['required' => true],
                    'description'       => ['required' => true],
                ]
            );

            // Dados de informação
            $info = [
                '"SECTION"'     => $request->getPost('department')->toString(),
                '"PROGRAM"'     => $request->getPost('program')->toString(),
                '"NAME"'        => $request->getPost('front_identifiyer')->toString(),
                '"DESCRIPTION"' => $request->getPost('description')->toString(),
                '"UPDATED_BY"'  => Session::getValue('user_id'),
                '"UPDATED_AT"'  => date('Y-m-d H:i:s')
            ];


            $programModel = new Program();
            $update       = $programModel->database('system');
            $update->update($info)
                ->where('"ID"', $request->getQueryParam('id'))
                ->execute();

                // Insere novos grupos
            //$programModel->adicionarProgramaAoGrupo($formData['groups'], $uriParams['id']);

            $this->response(HttpStatusCode::ACCEPTED);
        } catch (\Exception $e) {
            $this->logger->emergency($e);
            $this->response(HttpStatusCode::NOT_ACCEPTABLE);
        }
    }
}
