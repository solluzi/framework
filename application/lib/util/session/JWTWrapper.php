<?php
declare (strict_types = 1);
namespace Session;

use DateTimeImmutable;
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
        $issuedAt   = new DateTimeImmutable();
        $expire     = $issuedAt->modify('+60 minutes')->getTimestamp();

        $tokenParam = [
            'iat'  => $issuedAt->getTimestamp(),
            'iss'  => $options['iss'],            // pode ser usado para descartar tokens de outros dominios
            'nbf'  => $issuedAt->getTimestamp(),  // Token não é valido antes de
            'exp'  => $expire,
            'data' => $options['userdata']
        ];
       
        return JWT::encode($tokenParam, getenv('JWT_ENCDEC_KEY'));
    }

    /**
     * decodifica token jwt
     */
    public static function decode($jwt)
    {
        try {
            return JWT::decode($jwt, getenv('JWT_ENCDEC_KEY'), ['HS256']);
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
