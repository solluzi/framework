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

use Admin\Model\SystemUser;
use Application\Interface\Middleware;
use Controller\HttpStatusCode;
use Controller\Response;
use Router\Request;
use Traits\PayloadEncryptTrait;

class ListController implements Middleware
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
            $usuariosModel = new SystemUser();

            // $parametros de pequisa
            $filterByLogin  = (isset($formData['login']) && !empty($formData['login'])) ? "%{$formData['login']}%" : null;
            $filterByName   = (isset($formData['name'])  && !empty($formData['name']))  ? "%{$formData['name']}%"  : null;
            $filterByStatus = $formData['active'] ?? false;
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
            $limit = (int)$uriParams['by_page'];

            // Quantas paginas terá na tabela?
            $paginas = ceil($totalRegistros->count / $limit);

            // Calcula o offset para a página
            $offset = ($uriParams['page'] - 1) * $limit;
            #######################################################
            ################## FIM PAGINAÇÃO ######################
            #######################################################


            $lista    = $usuariosModel->database('system')
                ->select('u', 
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
            $resposta['data'] = [
                'records'      => $lista,
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
