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

namespace Admin\Controllers\Logs;

use Admin\Model\SqlLog;
use Admin\Traits\AclTrait;
use Solluzi\Controller\AbstractController;
use Solluzi\Controller\Request;
use Solluzi\Controller\Traits\HttpStatusCode;
use Solluzi\Controller\Traits\PayloadEncryptTrait;
use Solluzi\Psr\Logger\FileLogger;

/**
 * System SQL Log Class
 * Get and filters all sql log of executed instructions
 */

class SqlLogController extends AbstractController
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
            // parametros recebidos da url
            $uriParams = $request->getQueryParams();

            // Model
            $model = new SqlLog();

            // Campo para filtro
            $filterByLogin = $formData['login'] ?? null;
            $date_start    = $formData['start'] ?? null;
            $date_end      = $formData['end'] ?? null;

            #######################################################
            ################# INICIO da PAGINAÇÃO #################
            #######################################################
            // Total de registros
            $totalRegistros = $model->database('log')
                ->select('', ['COUNT(*)'])
                ->where('"USER_ID"', $request->getPost('login')->toString())
                ->between('DATE("CREATED_AT")', [$request->getPost('start')->toDate2Us(), $request->getPost('end')->toDate2Us()])
                ->get();

            // Registro por página
            $limit = (int)$request->getQueryParam('by_page');

            // Quantas paginas terá na tabela?
            $paginas = ceil($totalRegistros->count / $limit);

            // Calcula o offset para a página
            $offset = ($request->getQueryParam('page') - 1) * $limit;
            #######################################################
            ################## FIM PAGINAÇÃO ######################
            #######################################################

            $sqlLogResult = $model->database('log')
                ->select('ssl', ['ssl."COMMAND" command', '"FN_DATE2BR"(ssl."CREATED_AT", true  ) created_at'])
                ->where('"USER_ID"', $request->getPost('login')->toString())
                ->between('DATE("CREATED_AT")', [
                    $request->getPost('start')->toDate2Us(),
                    $request->getPost('end')->toDate2Us()
                ])
                ->limit($limit, $offset)
                ->getAll();

            // Fomatação de registros
            $resposta = [
                'records'      => $sqlLogResult,
                'pages'        => $paginas,
                'totalRecords' => $totalRegistros->count
            ];

            $payload = ['data' => $this->encrypt($resposta)];
            $this->response(HttpStatusCode::OK, $payload);
        } catch (\Exception $e) {
            $this->logger->emergency($e->getMessage());
            $this->response(HttpStatusCode::BAD_REQUEST);
        }
    }
}
