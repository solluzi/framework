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
            $filterByLogin = $formData['login'] ?? null;
            $date_start    = $formData['start'] ?? null;
            $date_end      = $formData['end'] ?? null;

            #######################################################
            ################# INICIO da PAGINAÇÃO #################
            #######################################################
            // Total de registros
            $totalRegistros = $sqlLogModel->database('log')
                ->select('', ['COUNT(*)'])
                ->where('"USER_ID"', $filterByLogin)
                ->between('DATE("CREATED_AT")', [$date_start, $date_end])
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
                ->select('ssl', ['ssl."COMMAND" command', '"FN_DATE2BR"(ssl."CREATED_AT") created_at'])
                ->where('"USER_ID"', $filterByLogin)
                ->between('DATE("CREATED_AT")', [$date_start, $date_end])
                ->limit($limit, $offset)
                ->getAll();

            // Fomatação de registros
            $resposta['data'] = [
                'records'      => $sqlLogResult,
                'pages'        => $paginas,
                'totalRecords' => $totalRegistros->count
            ];

            $payload = $this->encrypt($resposta);

            return Response::json(['data' => $payload], HttpStatusCode::OK);
        } catch (\Exception $e) {
            return Response::json([$e->getMessage()], HttpStatusCode::BAD_REQUEST);
        }
    }
}
