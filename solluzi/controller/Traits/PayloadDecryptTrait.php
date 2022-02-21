<?php
declare(strict_types = 1);
namespace Solluzi\Controller\Traits;

use Nullix\CryptoJsAes\CryptoJsAes;

trait PayloadDecryptTrait
{
    public function decrypt($input)
    {
        // Original
        $encrypted = base64_decode($input);
        $key       = pack("H*", getenv("PAYLOAD_KEY"));                                                           // keys must be: 8/16/32 bit
        $iv        = pack("H*", getenv("PAYLOAD_IV"));
        $decrypted = openssl_decrypt($encrypted, 'aes-128-cbc', $key, OPENSSL_ZERO_PADDING, $iv);
        $resultado = json_decode(base64_decode($decrypted), true);
        return $resultado; 
    }
}