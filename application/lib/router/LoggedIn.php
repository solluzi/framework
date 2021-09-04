<?php

declare(strict_types=1);
/**
 * 
 */

namespace Router;

use Session\JWTWrapper;

class LoggedIn
{
    /**
     * Undocumented variable
     *
     * @var [type]
     */
    private $jwt;

    /**
     * Undocumented function
     *
     * @return boolean
     */
    public function isLogged()
    {
        try {
            $authorization = getallheaders();
            (isset($authorization['Authorization'])) ? list($this->jwt) = sscanf($authorization['Authorization'], 'Bearer %s') : null;
            return JWTWrapper::decode($this->jwt);
        } catch (\Exception $e) {
            http_response_code(401);
        }
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function getUserId()
    {
        try {
            $authorization = getallheaders();
            list($jwt) = sscanf($authorization['Authorization'], 'Bearer %s');
            $user = JWTWrapper::decode($jwt);
            return $user->data->id;
        } catch (\Exception $e) {
            http_response_code(400);
        }
    }
}
