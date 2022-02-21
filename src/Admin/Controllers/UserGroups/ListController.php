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

namespace Admin\Controllers\UserGroups;

use Admin\Model\Group;
use Admin\Traits\AclTrait;
use Solluzi\Controller\AbstractController;
use Solluzi\Controller\Form;
use Solluzi\Controller\Request;
use Solluzi\Controller\Traits\HttpStatusCode;
use Solluzi\Controller\Traits\PayloadEncryptTrait;
use Solluzi\Psr\Logger\FileLogger;

class ListController extends AbstractController
{
    use PayloadEncryptTrait;
    use AclTrait;

    private $form;
    private $logger;

    public function __construct()
    {
        $this->isProtected(get_class($this));

        $this->form   = new Form();
        $this->logger = new FileLogger();
    }

    public function process(Request $request)
    {
        try {
            // Model
            $model = new Group();

            // Campo para filtro
            $name         = $request->getPost('name')->toString();
            $filterByName = (isset($name) && !empty($name)) ? "%{$name}%" : null;

            /*************************************************************************/
            /*                            PAGINATION START
            /*************************************************************************/
            // Total de registros
            $totalRegistros = $model->database('system')
                ->select('"SG"', ['COUNT(*) as total'])
                ->where('"SG"."NAME"', $filterByName, 'LIKE')
                ->get();

            // Registro por página
            $limit = (int)$request->getQueryParam('by_page');

            // Quantas paginas terá na tabela?
            $paginas = ceil($totalRegistros->total / $limit);

            // Calcula o offset para a página
            $offset = ($request->getQueryParam('page') - 1) * $limit;
            /*************************************************************************/
            /*                            PAGINATION END
            /*************************************************************************/

            $resultados = $model->database('system')
                                ->select('sg', ['sg."ID" id', 'sg."NAME" "name"'])
                                ->where('sg."NAME"', $filterByName, 'LIKE')
                                ->limit($limit, $offset)
                                ->getAll();

            // Fomatação de registros
            $resposta = [
                'records'      => $resultados,
                'pages'        => $paginas,
                'totalRecords' => $totalRegistros->total
            ];

            $payload = ['data' => $this->encrypt($resposta)];
            $this->response(HttpStatusCode::OK, $payload);
        } catch (\Exception $e) {
            $this->logger->emergency($e->getMessage());
            $this->response(HttpStatusCode::BAD_REQUEST);
        }
    }
}
