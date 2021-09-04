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

namespace Admin\Controllers\SystemConfiguration;

use Admin\Model\SystemConfiguration;
use Application\Interface\Middleware;
use Controller\HttpStatusCode;
use Controller\Response;
use Router\Request;
use Traits\PayloadEncryptTrait;

class Read implements Middleware
{
    use PayloadEncryptTrait;


    public function process(Request $request)
    {
        try {
            // parametros recebidos da url
            $uriParams = $request->getQueryParams();

            // Model
            $configuracaoModel = new SystemConfiguration();

            // Campo para filtro
            $chave = (isset($uriParams['chave']) && !empty($uriParams['chave'])) ? $uriParams['chave'] : null;

            #######################################################
            ################## FIM PAGINAÇÃO ######################
            #######################################################

            // Lista os registros
            $resultados  = $configuracaoModel->start('system')
                ->select('', ['valor'])
                ->where('chave', $chave)
                ->limit(1)
                ->get();

            // Fomatação de registros
            $resposta['data'] = [
                'registros' => $resultados,
            ];

            $payload = $this->encrypt($resposta);

            return Response::json(['data' => $payload], HttpStatusCode::OK);
        } catch (\Exception $e) {
            return Response::json([], HttpStatusCode::BAD_REQUEST);
        }
    }
}
