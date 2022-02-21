<?php

/**
 * @version     1.0.0
 * @category    Action
 * @package     App
 * @subpackage  User
 * @author      Mauro Joaquim Miranda
 * @copyright   Copyright (c) 2020 Solluzi Tecnologia da Informação LTDA-ME. (https://mauromiranda.dev)
 * @license     https://mauromiranda.dev/framework-license
 *
 * Read
 *  Gets all system users informations
 */

declare(strict_types=1);

namespace Admin\Controllers\User;

use Admin\Model\User;
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
            $usuariosModel = new User();

            // $parametros de pequisa
            $login          = $request->getPost('login')->toString();
            $name           = $request->getPost('name')->toString();

            $filterByLogin  = (isset($login) && !empty($login)) ? "%{$login}%" : null;
            $filterByName   = (isset($name)  && !empty($name))  ? "%{$name}%"  : null;
            $filterByStatus = $request->getPost('active')->toString() ?? false;
            #######################################################
            ################# INICIO da PAGINAÇÃO #################
            #######################################################
            // Total de registros
            $totalRegistros = $usuariosModel->database('system')
                ->select('u', ['COUNT(*)'])
                ->where('u."LOGIN"', $filterByLogin, 'LIKE')
                ->where('u."NAME"', $filterByName, 'LIKE')
                ->where('u."ACTIVE"', $filterByStatus)
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


            $lista    = $usuariosModel->database('system')
                ->select(
                    'u',
                    [
                        'u."ID" id',
                        'u."NAME" "name"',
                        'u."LOGIN" login',
                        'u."LOGIN" email',
                        'u."ACTIVE" status'
                    ]
                )
                ->where('u."LOGIN"', $filterByLogin, 'LIKE')
                ->where('u."NAME"', $filterByName, 'LIKE')
                ->where('u."ACTIVE"', $filterByStatus)
                ->limit($limit, $offset)
                ->getAll();

            // Fomatação de registros
            $resposta = [
                'records'      => $lista,
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
