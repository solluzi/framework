<?php

declare(strict_types=1);

namespace Solluzi\Lib\Controller;

use Session\Session;

/**
 * Undocumented class
 */
class Response
{
    /**
     * Undocumented function
     *
     * @param array $data
     * @param Int $code
     * @return void
     */
    static public function json($data, $code)
    {
        http_response_code($code);
        header('Content-type: application/json');
        $resposta = json_encode($data, 1);
        echo $resposta;
    }
}
