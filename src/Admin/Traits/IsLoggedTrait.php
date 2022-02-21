<?php

declare(strict_types=1);

namespace Admin\Traits;

use Admin\Model\Acl;
use DateTimeImmutable;
use Solluzi\Controller\Traits\HttpStatusCode;
use Solluzi\Psr\Logger\FileLogger;
use Solluzi\Security\Jwt\JWTWrapper;
use Solluzi\Security\Session\Session;

/**
 *
 */
trait IsLoggedTrait
{
    private $jwt;
    private $conn;

    public function checkAccess()
    {

        try {
            $authorization = getallheaders();

            (isset($authorization['Authorization'])) ? list($this->jwt) = sscanf($authorization['Authorization'], 'Bearer %s') : null;

            $token = (!empty(JWTWrapper::decode($this->jwt))) ? JWTWrapper::decode($this->jwt) : false;
            $iss   = $token->iss;
            $tuid  = $token->data->uid ?? null;
            $exp   = $token->exp;
            $nbf   = $token->nbf;

            $now = new DateTimeImmutable();
            $today = $now->getTimestamp();

            // Pesquisa a sessão salva no banco de dados
            $uid    = ($token->data->uid) ?? ' ';
            $model  = new Acl();
            $result = $model->database('system')
                            ->instruction('SELECT')
                            ->instructionValues($uid)
                            ->get();

            if (($iss) && ($tuid) && ($exp) && !empty($result->acl) && (($nbf < $today)) && (($exp > $today))) {
                $jsonResult = json_decode($result->acl);
                Session::setValue('user_id', $jsonResult->user);
                Session::setValue('group_id', $jsonResult->group);
            } else {
                http_response_code(HttpStatusCode::UNAUTHORIZED);
                exit;
            }
        } catch (\Exception $e) {
            $logger = new FileLogger();
            $logger->emergency($e->getMessage());
            return HttpStatusCode::INTERNAL_SERVER_ERROR;
        }
    }
}
