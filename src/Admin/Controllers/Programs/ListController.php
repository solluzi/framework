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

use Admin\Model\Program;
use Admin\Traits\AclTrait;
use Solluzi\Controller\AbstractController;
use Solluzi\Controller\Request;
use Solluzi\Controller\Traits\HttpStatusCode;
use Solluzi\Controller\Traits\PayloadEncryptTrait;
use Solluzi\Psr\Logger\FileLogger;

class ListController extends AbstractController
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
            // Model
            $programModel = new Program();


            // Campos para filtro
            $name                = $request->getPost('name')->toString();
            $description         = $request->getPost('description')->toString();
            $filterByName        = (isset($name))       ? "%{$name}%"       : null;
            $filterByDescription = (isset($description)) ? "%{$description}%" : null;

            #######################################################
            ################# INICIO da PAGINAÇÃO #################
            #######################################################
            // Total de registros
            $totalRegistros = $programModel->database('system')
                ->select('', ['COUNT(*)'])
                ->where('"NAME"', $filterByName, 'LIKE')
                ->where('"DESCRIPTION"', $filterByDescription, 'LIKE')
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

            $listaDefilterByProgram = $programModel->database('system')
                ->select('p', ['p."ID" id', 'p."SECTION" section', 'p."DESCRIPTION" description', 'p."NAME" uname', 'p."PRIVATE" status'])
                ->where('"NAME"', $filterByName, 'LIKE')
                ->where('"DESCRIPTION"', $filterByDescription, 'LIKE')
                ->orderBy('"PRIVATE"', 'DESC')
                ->limit($limit, $offset)
                ->getAll();


            // Fomatação de registros
            $resposta = [
                'records'       => $listaDefilterByProgram,
                'pages'         => $paginas,
                'totalRecords' => $totalRegistros->count
            ];

            $payload = ['data' => $this->encrypt($resposta)];

            $this->response(HttpStatusCode::OK, $payload);
        } catch (\Exception $e) {
            $this->logger->emergency($e->getMessage());
            $this->response(HttpStatusCode::NOT_ACCEPTABLE);
        }
    }
}
