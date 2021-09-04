<?php
declare (strict_types = 1);
namespace Session;

use Firebase\JWT\JWT;
use stdClass;

class JWTWrapper
{
    //const KEY = '7Fsxc2A865V6'; //chave
    //const KEY = getenv('token_key'); //chave
    /**
     * Geração de um novo token jwt
     */
    public static function encode(array $options)
    {
        $issuedAt = time();
        $expire = $issuedAt + $options['expiration_sec']; // tempo de expiração
        $tokenParam = [
            'iss'  => $options['iss'],      // pode ser usado para descartar tokens de outros dominios
            'sub'  => $options['sub'],
            'aud'  => $options['aud'],
            'exp'  => $expire,              // expiração do token
            'nbf'  => $issuedAt - 1,        // Token não é valido antes de
            'iat'  => $issuedAt,            // timestamp de geração do token
            'data' => $options['userdata']
        ];
       
        return JWT::encode($tokenParam, $_ENV['JWT_ENCDEC_KEY']);
    }

    /**
     * decodifica token jwt
     */
    public static function decode($jwt)
    {
        try {
            return JWT::decode($jwt, $_ENV['JWT_ENCDEC_KEY'], ['HS256']);
        } catch (\Exception $e) {
            $obj = new stdClass;
            $obj->iss = null;
            $obj->sub = null;
            $obj->aud = null;
            $obj->exp = null;
            $obj->nbf = null;
            $obj->iat = null;
            return $obj;
        }
    }

    public static function invalidate($token)
    {
        
    }
}
