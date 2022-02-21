<?php
declare(strict_types=1);
namespace Solluzi\Controller\Traits;

use Solluzi\Security\Jwt\JWTWrapper;

trait JWTPayloadTrait
{
    public function payload($id)
    {
        $tokenId      = base64_encode(openssl_random_pseudo_bytes(32));
        $tokenPayload = [
            'iss'            => getenv('ISS'),
            'sub'            => getenv('SUB'),
            'aud'            => getenv('AUD'),
            'expiration_sec' => getenv('EXPIRATION_SEC'),
            'jti'            => $tokenId,
            'userdata'       =>  [
               'uid' => $id
            ]
        ];
        $token        = JWTWrapper::encode($tokenPayload);
        return $token;
    }
}