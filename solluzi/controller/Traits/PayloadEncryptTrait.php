<?php
declare(strict_types=1);
namespace Solluzi\Controller\Traits;

trait PayloadEncryptTrait
{
    public function encrypt($input)
    {
        $key        = pack("H*", getenv("PAYLOAD_KEY"));                                             // keys must be: 8/16/32 bit
        $iv         = pack("H*", getenv("PAYLOAD_IV"));
        $base64_str = base64_encode(json_encode($input));
        $encrypted  = openssl_encrypt($base64_str, "aes-128-cbc", $key, 0, $iv);
        return base64_encode($encrypted);
    }
}