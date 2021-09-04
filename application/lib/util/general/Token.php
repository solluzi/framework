<?php
declare(strict_types=1);

namespace General;

final class Token
{
    public static function generate()
    {
        // generate a random string
        $token = openssl_random_pseudo_bytes(32);

        // convert de bynary data into hexadecimal representation
        $token = bin2hex($token);

        // print it
        return $token;
    }
}
