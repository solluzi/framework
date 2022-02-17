<?php

declare(strict_types=1);

namespace Solluzi\Lib\Traits;

use Admin\Model\SystemAccessLog;
use Admin\Model\SystemUser;
use Admin\Model\SystemUserGroup;
use DateTime;
use DateTimeImmutable;
use Solluzi\Lib\Controller\HttpStatusCode;
use Solluzi\Lib\Util\Session\JWTWrapper;
use Solluzi\Lib\Util\Session\Session;

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
           
            $now = new DateTimeImmutable();
            
             // Pesquisa a sessão salva no banco de dados
             $uid = ($decriptToken->data->uid) ?? ' ';
             $accessLogQuery    = new SystemAccessLog();
             $accessSelect      = $accessLogQuery->database('log');
             $resultLogDeAcesso = $accessSelect
                ->select('"AL"', ['"AL"."LOGIN"'])
                ->where('"AL"."SESSION"', $this->jwt)
                ->whereNull('"AL"."LOGGED_OUT"')
                ->where('"AL"."KEY"', $uid)
                ->get();

            // Pesquisa o id do usuário para a sessão
            $usuario       = $resultLogDeAcesso->LOGIN ?? ' ';
            $usuarioQuery  = new SystemUser;
            $usuarioSelect = $usuarioQuery->database('system');
            $usuarioResult = $usuarioSelect
                ->select('"SU"', ['"SU"."LOGIN"', '"SU"."ID"'])
                ->where('"SU"."LOGIN"', $usuario)
                ->get();
                
            // Pesquisa o grupo do usuário
            $userId = ($usuarioResult->ID) ?? ' ';
            $usuarioGrupoQuery  = new SystemUserGroup;
            $usuarioGrupoSelect = $usuarioGrupoQuery->database('system');
            $usuarioGrupoResult = $usuarioGrupoSelect
                ->select('"SUG"', ['"SUG"."GROUP_ID"'])
                ->where('"SUG"."USER_ID"', $userId)
                ->get();
            
            if (
                ($decriptToken->iss) 
                && ($decriptToken->data->uid) 
                && ($decriptToken->exp) 
                && !empty($usuarioResult)
                && (($decriptToken->nbf < $now->getTimestamp()))
                && (($decriptToken->exp > $now->getTimestamp()))
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
