<?php

/**
 * @version     1.0.0
 * @category    Action
 * @package     App
 * @subpackage  Group
 * @author      Mauro Joaquim Miranda
 * @copyright   Copyright (c) 2020 Solluzi Tecnologia da Informação LTDA-ME. (https://mauromiranda.dev)
 * @license     https://mauromiranda.dev/framework-license
 *
 * Read
 *  Gets and Filter all group informations from table
 */

declare(strict_types=1);

namespace Admin\Controllers\SystemSection;

use Admin\Model\SystemProgramSection;
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
            // Parametros recebidos do formulário
            $formData = $request->getBody();

            // parametros recebidos da url
            $uriParams = $request->getQueryParams();

            // Model
            $secaoModel = new SystemProgramSection();

            // Campos para filtro
            $filterByName = (isset($formData['name']) && !empty($formData['name'])) ? "%{$formData['name']}%" : null;

            #######################################################
            ################# INICIO da PAGINAÇÃO #################
            #######################################################
            // Total de registros
            $totalRegistros = $secaoModel->database('system')
                ->select('', ['COUNT(*)'])
                ->where('"NAME"', $filterByName, 'LIKE')
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

            $listaDeSecao = $secaoModel->database('system')
                ->select('s', ['s."ID" id', 's."NAME" "name"'])
                ->where('"NAME"', $filterByName, 'LIKE')
                ->orderBy('"NAME"', 'ASC')
                ->limit($limit, $offset)
                ->getAll();

            // Fomatação de registros
            $resposta['data'] = [
                'records'      => $listaDeSecao,
                'pages'        => $paginas,
                'totalRecords' => $totalRegistros->count
            ];

            $payload = $this->encrypt($resposta);

            return Response::json(['data' => $payload], HttpStatusCode::OK);
        } catch (\Exception $e) {
            return Response::json([], HttpStatusCode::BAD_REQUEST);
        }
    }
}
