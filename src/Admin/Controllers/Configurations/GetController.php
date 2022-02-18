<?php

/**
 * @version     1.0.0
 * @category    Action
 * @package     App
 * @subpackage  Preference
 * @author      Mauro Joaquim Miranda
 * @copyright   Copyright (c) 2020 Solluzi Tecnologia da Informação LTDA-ME. (https://mauromiranda.dev)
 * @license     https://mauromiranda.dev/framework-license
 *
 * SystemStatus
 *  Verifies if the system is online
 *
 */

declare(strict_types=1);

namespace Admin\Controllers\Configurations;

use Admin\Model\SystemConfiguration;
use Application\Interface\Middleware;
use Controller\HttpStatusCode;
use Controller\Response;
use Router\Request;
use Traits\PayloadEncryptTrait;

class GetController implements Middleware
{
    use PayloadEncryptTrait;


    public function process(Request $request)
    {
        try {
            /*
            |--------------------------------------------------------------------------
            |                                query params
            |--------------------------------------------------------------------------
            |
            | get all parameters in the setted in the url
            |
            */

            $uriParams = $request->getQueryParams();

            /*
            |--------------------------------------------------------------------------
            |                           System Configuration Model
            |--------------------------------------------------------------------------
            |
            | call the specified table or function
            |
            */

            $configuracaoModel = new SystemConfiguration();

            /*
            |--------------------------------------------------------------------------
            |                                    Filter
            |--------------------------------------------------------------------------
            |
            | we build a filter for our select statement
            |
            */

            $chave = (isset($uriParams['chave']) && !empty($uriParams['chave'])) ? $uriParams['chave'] : null;

            /*
            |--------------------------------------------------------------------------
            |                                  start
            |--------------------------------------------------------------------------
            |
            | make connection to access the table and executes the select statement and
            | limits it in one result
            |
            */

            $resultados  = $configuracaoModel->database('system')
                ->select('c', ['c."VALUE"'])
                ->where('c."KEY"', $chave)
                ->limit(1)
                ->get();
            
            
           /*
           |--------------------------------------------------------------------------
           |                                  response
           |--------------------------------------------------------------------------
           |
           | formats the data to be returned in the frontend
           |
           */

            $resposta['data'] = [
                'registros' => $resultados,
            ];

            /*
            |--------------------------------------------------------------------------
            |                                  encrypt
            |--------------------------------------------------------------------------
            |
            | gets the resonse data and encripts it to make it safe for the frontend
            | and others requests
            |
            */

            $payload = $this->encrypt($resposta);

            /*
            |--------------------------------------------------------------------------
            |                                  return
            |--------------------------------------------------------------------------
            |
            | returns the data with encrypted payload and and http status code
            |
            */

            return Response::json(['data' => $payload], HttpStatusCode::OK);
        } catch (\Exception $e) {
            /*
            |--------------------------------------------------------------------------
            |                                  exception
            |--------------------------------------------------------------------------
            |
            | returns the error raised in the database exception
            |
            */

            return Response::json([], HttpStatusCode::BAD_REQUEST);
        }
    }
}
