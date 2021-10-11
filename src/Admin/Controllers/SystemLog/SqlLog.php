<?php

/**
 * @version     1.0.0
 * @category    Action
 * @package     App
 * @subpackage  Log
 * @author      Mauro Joaquim Miranda
 * @copyright   Copyright (c) 2020 Solluzi Tecnologia da Informação LTDA-ME. (https://mauromiranda.dev)
 * @license     https://mauromiranda.dev/framework-license
 */

declare(strict_types=1);

namespace Admin\Controllers\SystemLog;

use Admin\Model\SystemSQLLog;
use Application\Interface\Middleware;
use Controller\HttpStatusCode;
use Controller\Response;
use Router\Request;
use Traits\PayloadEncryptTrait;

/**
 * System SQL Log Class
 * Get and filters all sql log of executed instructions
 */

class SqlLog implements Middleware
{
    use PayloadEncryptTrait;

    public function process(Request $request)
    {
        try {
            // Parametros recebidos do formulário
            $formData  = $request->getBody();

            // parametros recebidos da url
            $uriParams = $request->getQueryParams();

            // Model
            $sqlLogModel = new SystemSQLLog();

            // Campo para filtro
            $login    = (isset($formData['login'])       && !empty($formData['login']))       ? $formData['login']       : null;
            $data_ini = (isset($formData['data_inicio']) && !empty($formData['data_inicio'])) ? $formData['data_inicio'] : null;
            $data_fim = (isset($formData['data_fim'])    && !empty($formData['data_fim']))    ? $formData['data_fim']    : null;

            #######################################################
            ################# INICIO da PAGINAÇÃO #################
            #######################################################
            // Total de registros
            $totalRegistros = $sqlLogModel->database('log')
                ->select('', ['COUNT(*)'])
                ->where('login', $login)
                ->between('DATE(created_at)', [$data_ini, $data_fim])
                ->get();

            // Registro por página
            $limit = (int)$uriParams['by_page'];

            // Quantas paginas terá na tabela?
            $paginas = ceil($totalRegistros->count / $limit);

            // Calcula o offset para a página
            $offset = ($uriParams['page'] - 1) * $limit;
            #######################################################
            ################## FIM PAGINAÇÃO ######################
            #######################################################

            $sqlLogResult = $sqlLogModel->database('log')
                ->select('', ['*'])
                ->where('login', $login)
                ->between('DATE(created_at)', [$data_ini, $data_fim])
                ->limit($limit, $offset)
                ->getAll();

            // Fomatação de registros
            $resposta['data'] = [
                'registros'       => $sqlLogResult,
                'paginas'         => $paginas,
                'total_registros' => $totalRegistros->count
            ];

            $payload = $this->encrypt($resposta);

            return Response::json(['data' => $payload], HttpStatusCode::OK);
        } catch (\Exception $e) {
            return Response::json([$e->getMessage()], HttpStatusCode::BAD_REQUEST);
        }
    }
}
