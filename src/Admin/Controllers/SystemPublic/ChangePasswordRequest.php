<?php

/**
 * @version     1.0.0
 * @category    Action
 * @package     App
 * @subpackage  Profile
 * @author      Mauro Joaquim Miranda
 * @copyright   Copyright (c) 2020 Solluzi Tecnologia da Informação LTDA-ME. (https://mauromiranda.dev)
 * @license     https://mauromiranda.dev/framework-license
 *
 * SystemUserPassLinkReset
 *  Send email with link for user changing password
 */

declare(strict_types=1);

namespace Admin\Controllers\SystemPublic;

use Admin\Model\SystemUser;
use App\Helper\SolicitaResetDeNotification;
use Solluzi\Interfaces\Middleware;
use Solluzi\Lib\Controller\HttpStatusCode;
use Solluzi\Lib\Controller\Response;
use Solluzi\Lib\Traits\JWTPayloadTrait;

class ChangePasswordRequest implements Middleware
{
    use JWTPayloadTrait;

    private $conn;
    private $enviarEmail;

    public function __construct()
    {
        $this->enviarEmail = new SolicitaResetDeNotification();
    }


    public function process($request)
    {
        try {
            $formData     = $request->getBody();
            $responseCode = HttpStatusCode::NO_CONTENT;

            // Pesquisa o e-mail do usuário
            $usuarioEmailView = new SystemUser();
            $usuarioEmailQuery = $usuarioEmailView->database('system');
            $usuarioEmailResult = $usuarioEmailQuery
                ->select('', ['info', 'id', 'login'])
                ->where('login', $formData['login'])
                ->get();

            $result = json_decode($usuarioEmailResult->info);

            if (($usuarioEmailResult) and !empty($result->pessoal)) {
                $uid   = md5(uniqid('solluzi_', true));
                $token = $this->payload($uid);


                // Insere o token na tabela do usuário
                if (isset($usuarioEmailResult->id)) {
                    $info = ['token_reset' => $token];
                    $usuarioModel = new SystemUser();
                    $usuarioModel->database('system')
                        ->update($info)
                        ->where('id', $usuarioEmailResult->id)
                        ->execute();
                }

                // Formata a mensagem
                $message = file_get_contents(dirname(__DIR__, 4) . '/public/templates/reset_password.html');
                $message = str_replace('%url%', getenv('FRONTEND_URL'), $message);
                $message = str_replace('%name%', $usuarioEmailResult->login, $message);
                $message = str_replace('%token%', $token, $message);

                // Envia o e-mail
                $resposta = $this->enviarEmail->send($result->pessoal, $message);

                // armazena o cídogo HTTP da resposta
                $responseCode = HttpStatusCode::RESET_CONTENT;
            }

            return Response::json([], $responseCode);
        } catch (\Exception $e) {
            return Response::json([], HttpStatusCode::BAD_REQUEST);
        }
    }
}
