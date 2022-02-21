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
 */

declare(strict_types=1);

namespace Admin\Controllers\Security;

use Admin\Model\SignIn;
use Solluzi\Controller\AbstractController;
use Solluzi\Controller\Form;
use Solluzi\Controller\Request;
use Solluzi\Controller\Traits\HttpStatusCode;
use Solluzi\Controller\Traits\JWTPayloadTrait;
use Solluzi\Controller\Traits\PayloadEncryptTrait;
use Solluzi\Psr\Logger\FileLogger;

/**
 * SystemSignIn
 * executes tasks to allow a certain user to signin
 *
 */
class SignInController extends AbstractController
{
    use JWTPayloadTrait;
    use PayloadEncryptTrait;

    private $form;
    private $model;
    private $logger;


    public function __construct()
    {
        $this->form   = new Form();
        $this->model  = new SignIn();
        $this->logger = new FileLogger();
    }


    public function process(Request $request)
    {
        try {
            // Validação de dados de formulários
            $this->form->setData($request->getPosts());
            $this->form->isValid(
                [
                    'username' => ['required' => true],
                    'password' => ['required' => true]
                ],
            );

            $chave  = md5(uniqid('solluzi_', true));  // chave unica
            $sessao = $this->payload($chave);

            $dados = json_encode([
                'usuario' => $request->getPost('username')->toString(),
                'senha'   => $request->getPost('password')->toString(),
                'chave'   => $chave,
                'sessao'  => $sessao
            ]);

            $usuarioResult = $this->model->database('system');
            $selectResult  = $usuarioResult
                ->instruction("SELECT")
                ->instructionValues($dados)
                ->get();

            // variaveis que serão informadas ao client
            $httpResponse  = HttpStatusCode::OK;

            $function    = json_decode($selectResult->login);
            $loginResult = (array)$function;

            if ($loginResult['logged']) {
                $payload = $this->encrypt($loginResult);
                $this->response($httpResponse, ['data' => $payload]);
            } else {
                $this->response(HttpStatusCode::NO_CONTENT, []);
            }
        } catch (\Exception $e) {
            $this->logger->emergency($e->getMessage());
            $this->response(HttpStatusCode::NOT_ACCEPTABLE);
        }
    }
}
