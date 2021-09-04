<?php
declare(strict_types=1);
namespace Traits;

use Session\JWTWrapper;

trait JWTPayloadTrait
{
    public function payload($id)
    {
        $tokenId      = base64_encode(openssl_random_pseudo_bytes(32));
        $tokenPayload = [
            'iss'            => $_ENV['ISS'],
            'sub'            => $_ENV['SUB'],
            'aud'            => $_ENV['AUD'],
            'expiration_sec' => $_ENV['EXPIRATION_SEC'],
            'jti'            => $tokenId,
            'userdata'       =>  [
               'uid' => $id
            ]
        ];
        $token        = JWTWrapper::encode($tokenPayload);
        return $token;
    }
}