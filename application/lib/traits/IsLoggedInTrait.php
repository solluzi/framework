<?php

declare(strict_types=1);

namespace Traits;

use Admin\Model\SystemAccessLog;
use Admin\Model\SystemUser;
use Admin\Model\SystemUserGroup;
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
             $accessLogQuery    = new SystemAccessLog();
             $accessSelect      = $accessLogQuery->start('log');
             $resultLogDeAcesso = $accessSelect
                ->select('"AL"', ['"AL"."LOGIN"'])
                ->where('"AL"."SESSION"', $this->jwt)
                ->whereNull('"AL"."LOGGED_OUT"')
                ->where('"AL"."KEY"', $uid)
                ->get();

            // Pesquisa o is do usuário para a sessão
            $usuario       = $resultLogDeAcesso->LOGIN ?? ' ';
            $usuarioQuery  = new SystemUser;
            $usuarioSelect = $usuarioQuery->start('system');
            $usuarioResult = $usuarioSelect
                ->select('"SU"', ['"SU"."LOGIN"', '"SU"."ID"'])
                ->where('"SU"."LOGIN"', $usuario)
                ->get();
                
            // Pesquisa o grupo do usuário
            $userId = ($usuarioResult->ID) ?? ' ';
            $usuarioGrupoQuery  = new SystemUserGroup;
            $usuarioGrupoSelect = $usuarioGrupoQuery->start('system');
            $usuarioGrupoResult = $usuarioGrupoSelect
                ->select('"SUG"', ['"SUG"."GROUP_ID"'])
                ->where('"SUG"."USER_ID"', $userId)
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
                
                Session::setValue('user',  $usuarioResult->ID);
                Session::setValue('grupo', $usuarioGrupoResult->GROUP_ID);
                
                return HttpStatusCode::HTTP_CONTINUE;                    
            } else {
                $this->httpResponse = HttpStatusCode::FORBIDDEN;
            }
        } catch (\Exception $e) {
            return HttpStatusCode::INTERNAL_SERVER_ERROR;
        }
    }
}
