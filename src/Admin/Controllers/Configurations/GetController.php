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

use Admin\Model\Configuration;
use Admin\Traits\AclTrait;
use Solluzi\Controller\AbstractController;
use Solluzi\Controller\Request;
use Solluzi\Controller\Traits\HttpStatusCode;
use Solluzi\Controller\Traits\PayloadEncryptTrait;
use Solluzi\Psr\Logger\FileLogger;

class GetController extends AbstractController
{
    use PayloadEncryptTrait;
    use AclTrait;

    private $logger;

    public function __construct()
    {
        $this->isProtected(get_class($this));
        $this->logger = new FileLogger();
    }


    public function process(Request $request)
    {
        try {
            /*
            |--------------------------------------------------------------------------
            |                           System Configuration Model
            |--------------------------------------------------------------------------
            |
            | call the specified table or function
            |
            */

            $configuracaoModel = new Configuration();

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
                ->where('c."KEY"', $request->getQueryParam('key'))
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

            //$resposta['data'] = $resultados;

            /*
            |--------------------------------------------------------------------------
            |                                  encrypt
            |--------------------------------------------------------------------------
            |
            | gets the resonse data and encripts it to make it safe for the frontend
            | and others requests
            |
            */

            $payload = $this->encrypt($resultados->VALUE);

            /*
            |--------------------------------------------------------------------------
            |                                  return
            |--------------------------------------------------------------------------
            |
            | returns the data with encrypted payload and and http status code
            |
            */
            $this->response(HttpStatusCode::CREATED, ['data' => $payload]);
        } catch (\Exception $e) {
            /*
            |--------------------------------------------------------------------------
            |                                  exception
            |--------------------------------------------------------------------------
            |
            | returns the error raised in the database exception
            |
            */
            $this->logger->emergency($e->getMessage());
            $this->response(HttpStatusCode::NOT_ACCEPTABLE);
        }
    }
}
