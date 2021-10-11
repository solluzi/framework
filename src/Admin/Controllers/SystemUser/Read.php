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

namespace Admin\Controllers\SystemUser;

use Admin\Model\SystemUser;
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
            $formData  = $request->getBody();

            // parametros recebidos da url
            $uriParams = $request->getQueryParams();

            // Model
            $usuariosModel = new SystemUser();

            // $parametros de pequisa
            $login = (isset($formData['login']) && !empty($formData['login'])) ? "%{$formData['login']}%" : null;
            #######################################################
            ################# INICIO da PAGINAÇÃO #################
            #######################################################
            // Total de registros
            $totalRegistros = $usuariosModel->database('system')
                ->select('', ['COUNT(*)'])
                ->where('login', $login, 'LIKE')
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
                ->select('', ['*'])
                ->where('login', $login, 'LIKE')
                ->limit($limit, $offset)
                ->getAll();

            // Fomatação de registros
            $resposta['data'] = [
                'registros'       => $lista,
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
