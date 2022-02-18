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
 * SystemSignOut
 *  SignOut user and clean all sessions
 */

declare(strict_types=1);

namespace Admin\Controllers\Security;

use Admin\Model\SystemAccessLog;
use Solluzi\Interfaces\Middleware;
use Solluzi\Lib\Controller\HttpStatusCode;
use Solluzi\Lib\Controller\Response;
use Solluzi\Lib\Util\Session\JWTWrapper;

class SignOutController implements Middleware
{

    public function process($request)
    {
        try {
            $authorization = getallheaders();

            (isset($authorization['Authorization'])) ? list($this->jwt) = sscanf($authorization['Authorization'], 'Bearer %s') : null;
            $decriptToken   = (!empty(JWTWrapper::decode($this->jwt))) ? JWTWrapper::decode($this->jwt) : false;

            $logAcessoModel = new SystemAccessLog();
            $logAcessoQuery = $logAcessoModel->database('log');
            $log = $logAcessoQuery
                        ->select('', ['login'])
                        ->where('sessao', $this->jwt)
                        ->where('chave', $decriptToken->data->uid)
                        ->whereNull('saiu')
                        ->get();

            if ($log) {
                // LOG OTHER SESSIONS OUT #########################
                $info        = [
                    'saiu'  => date('Y-m-d H:i:s'),
                    'login' => $log->login
                ];
                $logoutQuery = $logAcessoModel->database('log');
                $logoutQuery
                    ->update($info)
                    ->where('login', $log->login)
                    ->whereNull('saiu')
                    ->execute();
            }

            return Response::json([], HttpStatusCode::ACCEPTED);
        } catch (\Exception $e) {
            return Response::json(null, HttpStatusCode::BAD_REQUEST);
        }
    }
}
