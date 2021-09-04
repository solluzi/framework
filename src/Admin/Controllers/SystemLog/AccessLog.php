<?php

/**
 * PHP version 7.4
 *
 * @category    Action
 * @package     App
 * @subpackage  log
 * @author      Mauro Joaquim Miranda <contato@mauromiranda.dev>
 * @license     https://mauromiranda.dev/framework-license MIT
 * @link        https://mauromiranda.dev
 */

declare(strict_types=1);

namespace Admin\Controllers\SystemLog;

use Admin\Model\SystemAccessLog;
use Application\Interface\Middleware;
use Controller\HttpStatusCode;
use Controller\Response;
use Router\Request;
use Traits\PayloadEncryptTrait;

/**
 * System Access Log View Class
 * Get all history of access logs from the table
 */
class AccessLog implements Middleware
{
    use PayloadEncryptTrait;


    public function process(Request $request)
    {
        try {
            // Parametros recebidos do formulário
            $data      = $request->getBody();

            // parametros recebidos da url
            $uriParams = $request->getQueryParams();

            // Model
            $logAcessoModel = new SystemAccessLog();

            // $campos para filtro
            $login       = (isset($data['login'])       && !empty($data['login']))      ? $data['login']        : null;
            $data_inicio = (isset($data['data_inicio']) && !empty($data['data_inicio'])) ? $data['data_inicio']  : null;
            $data_fim    = (isset($data['data_fim'])    && !empty($data['data_fim']))   ? $data['data_fim']     : null;
            #######################################################
            ################# INICIO da PAGINAÇÃO #################
            #######################################################
            // Total de registros
            $totalRegistros = $logAcessoModel->start('log')
                ->select('', ['COUNT(*)'])
                ->where('login', $login)
                ->between('DATE(acessou)', [$data_inicio, $data_fim])
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

            $logAcessoQuery = $logAcessoModel->start('log');
            $result         = $logAcessoQuery->select('', ['login', 'fn_data2br(acessou) as acessou','fn_data2br(saiu) as saiu' ])
                ->where('login', $login)
                ->between('DATE(acessou)', [$data_inicio, $data_fim])
                ->limit($limit, $offset)
                ->getAll();

            // Fomatação de registros
            $resposta['data'] = [
                'registros'       => $result,
                'paginas'         => $paginas,
                'total_registros' => $totalRegistros->count
            ];

            $payload = $this->encrypt($resposta);

            return Response::json(['data' => $payload], HttpStatusCode::OK);
        } catch (\Exception $e) {
            return Response::json([], HttpStatusCode::BAD_REQUEST);
        }
    }
}
