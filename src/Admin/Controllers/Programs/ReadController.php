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

namespace Admin\Controllers\Programs;

use Admin\Model\SystemProgram;
use Application\Interface\Middleware;
use Controller\HttpStatusCode;
use Controller\Response;
use Router\Request;
use Traits\PayloadEncryptTrait;

class ReadController implements Middleware
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
            $filterByProgramModel = new SystemProgram();
            
            
            // Campos para filtro
            $filterByName        = (isset($formData['name'])        && !empty($formData['name']))       ? "%{$formData['name']}%"       : null;
            $filterByDescription = (isset($formData['description']) && !empty($formData['description']))? "%{$formData['description']}%": null;

            #######################################################
            ################# INICIO da PAGINAÇÃO #################
            #######################################################
            // Total de registros
            $totalRegistros = $filterByProgramModel->database('system')
                ->select('', ['COUNT(*)'])
                ->where('"NAME"', $filterByName, 'LIKE')
                ->where('"DESCRIPTION"', $filterByDescription, 'LIKE')
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

            $listaDefilterByProgram = $filterByProgramModel->database('system')
                ->select('p', ['p."ID" id', 'p."SECTION" section', 'p."DESCRIPTION" description', 'p."NAME" uname', 'p."PRIVATE" status'])
                ->where('"NAME"', $filterByName, 'LIKE')
                ->where('"DESCRIPTION"', $filterByDescription, 'LIKE')
                ->orderBy('"PRIVATE"', 'DESC')
                ->limit($limit, $offset)
                ->getAll();
            
            
            // Fomatação de registros
            $resposta['data'] = [
                'records'       => $listaDefilterByProgram,
                'pages'         => $paginas,
                'totalRecords' => $totalRegistros->count
            ];

            $payload = $this->encrypt($resposta);

            return Response::json(['data' => $payload], HttpStatusCode::OK);
        } catch (\Exception $e) {
            return Response::json([$e->getMessage()], HttpStatusCode::BAD_REQUEST);
        }
    }
}
