<?php

declare(strict_types=1);

namespace Traits;

use Administracao\Model\AccessLog;
use Administracao\Model\Grupo;
use Administracao\Model\Usuario;
use Administracao\Model\UsuarioGrupo;
use Controller\HttpStatusCode;
use DateTime;
use Session\JWTWrapper;
use Session\Session;

/**
 * 
 */
trait IsLoggedinTrait
{
    private $jwt;
    private $conn;
    
    public function verifyAccess()
    {

        try {
            $authorization = getallheaders();

            (isset($authorization['Authorization'])) ? list($this->jwt) = sscanf($authorization['Authorization'], 'Bearer %s') : null;

            $decriptToken = (!empty(JWTWrapper::decode($this->jwt))) ? JWTWrapper::decode($this->jwt) : false;
            $tokenTime    = new DateTime();
            $agora        = new DateTime('now');

             // Pesquisa a sessão salva no banco de dados
             $uid = ($decriptToken->data->uid) ?? ' ';
             $accessLogQuery    = new AccessLog();
             $accessSelect      = $accessLogQuery->start('log');
             $resultLogDeAcesso = $accessSelect
                ->select('', ['login'])
                ->where('sessao', $this->jwt)
                ->whereNull('saiu')
                ->where('chave', $uid)
                ->get();

            // Pesquisa o is do usuário para a sessão
            $usuario       = $resultLogDeAcesso->login ?? ' ';
            $usuarioQuery  = new Usuario;
            $usuarioSelect = $usuarioQuery->start('system');
            $usuarioResult = $usuarioSelect
                ->select('', ['login', 'id'])
                ->where('login', $usuario)
                ->get();

            // Pesquisa o grupo do usuário
            $userId = ($usuarioResult->id) ?? ' ';
            $usuarioGrupoQuery  = new UsuarioGrupo;
            $usuarioGrupoSelect = $usuarioGrupoQuery->start('system');
            $usuarioGrupoResult = $usuarioGrupoSelect
                ->select('', ['grupo'])
                ->where('usuario', $userId)
                ->get();

            if (
                ($decriptToken->iss) 
                && ($decriptToken->aud) 
                && ($decriptToken->exp) 
                && !empty($usuarioResult)
                && ($tokenTime->setTimestamp($decriptToken->exp))
                && ($tokenTime->format('Y-m-d H:i:s') > $agora->format('Y-m-d H:i:s'))
            ) 
            {
                
                Session::setValue('user',  $usuarioResult->id);
                Session::setValue('grupo', $usuarioGrupoResult->grupo);
                
                return HttpStatusCode::HTTP_CONTINUE;                    
            } else {
                $this->httpResponse = HttpStatusCode::FORBIDDEN;
            }
        } catch (\Exception $e) {
            return HttpStatusCode::INTERNAL_SERVER_ERROR;
        }
    }
}
