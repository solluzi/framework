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

namespace Admin\Controllers\SystemPublic;

use Admin\Model\SystemLogin;
use Router\Request;
use Solluzi\Interfaces\Middleware;
use Solluzi\Lib\Controller\HttpStatusCode;
use Solluzi\Lib\Controller\Response;
use Solluzi\Lib\Controller\TrataFormInput;
use Solluzi\Lib\Form\Form;
use Solluzi\Lib\Traits\JWTPayloadTrait;
use Solluzi\Lib\Traits\PayloadEncryptTrait;

/**
 * SystemSignIn
 * executes tasks to allow a certain user to signin
 *
 */
class Login implements Middleware
{
    use JWTPayloadTrait;
    use PayloadEncryptTrait;

    private $form;
    private $loginQuery;
    private $trataInput;


    public function __construct()
    {
        $this->form           = new Form();
        $this->loginQuery     = new SystemLogin();
        $this->trataInput     = new TrataFormInput();
    }


    public function process(Request $request)
    {
        try {
            // Validação de dados de formulários
            $this->form->isValid(
                [
                    'username' => ['required' => true],
                    'password' => ['required' => true]
                ],
            );


            $input   = $request->getBody();

            $usuario = $this->trataInput->input($input['username'])->toString();
            $senha   = $this->trataInput->input($input['password'])->toString();


            $chave  = md5(uniqid('solluzi_', true));  // chave unica
            $sessao = $this->payload($chave);

            $dados = json_encode([
                'usuario' => $usuario,
                'senha'   => $senha,
                'chave'   => $chave,
                'sessao'  => $sessao
            ]);

            $usuarioResult = $this->loginQuery->database('system');
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
                return Response::json(['data' => $payload], $httpResponse);
            } else {
                return Response::json([], HttpStatusCode::UNAUTHORIZED);
            }
        } catch (\Exception $e) {
            return Response::json([$e->getMessage()], HttpStatusCode::BAD_REQUEST);
        }
    }
}
