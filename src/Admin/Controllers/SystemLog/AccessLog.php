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
            /*
            |--------------------------------------------------------------------------
            |                                  getBody
            |--------------------------------------------------------------------------
            |
            | Gets all forms inputs parameters from request
            |
            */

            $data      = $request->getBody();

            /*
            |--------------------------------------------------------------------------
            |                                  getQueryParams
            |--------------------------------------------------------------------------
            |
            | Gets All uri parameters
            |
            */

            $uriParams = $request->getQueryParams();

            /*
            |--------------------------------------------------------------------------
            |
            |--------------------------------------------------------------------------
            |
            |
            |
            */

            $accessLogModel = new SystemAccessLog();

            // $campos para filtro
            $login       = (isset($data['login'])       && !empty($data['login']))      ? $data['login']        : null;
            $data_inicio = (isset($data['data_inicio']) && !empty($data['data_inicio'])) ? $data['data_inicio'] : null;
            $data_fim    = (isset($data['data_fim'])    && !empty($data['data_fim']))   ? $data['data_fim']     : null;

            // Total de registros
            $totalRecords = $accessLogModel->database('log')
                ->select('al', ['COUNT(*) as total'])
                ->where('"LOGIN"', $login)
                ->between('DATE(LOGGED_IN)', [$data_inicio, $data_fim])
                ->get();

            // Registro por página
            $limit = (int)$uriParams['by_page'];

            // Quantas paginas terá na tabela?
            $pages = ceil($totalRecords->total / $limit);

            // Calcula o offset para a página
            $offset = ($uriParams['page'] - 1) * $limit;
            #######################################################
            ################## FIM PAGINAÇÃO ######################
            #######################################################

            $accessLogQuery = $accessLogModel->database('log');
            $result         = $accessLogQuery->select(
                'al',
                [
                                        '"LOGIN"',
                                        '"FN_DATE2BR"("LOGGED_IN", true) as acessou',
                                        '"FN_DATE2BR"("LOGGED_OUT", true) as saiu'
                ]
            )
                ->where('"LOGIN"', $login)
                ->between('DATE("LOGGED_IN")', [$data_inicio, $data_fim])
                ->limit($limit, $offset)
                ->getAll();

            // Fomatação de registros
            $response['data'] = [
                'registros'       => $result,
                'paginas'         => $pages,
                'total_registros' => $totalRecords->total
            ];

            $payload = $this->encrypt($response);

            return Response::json(['data' => $payload], HttpStatusCode::OK);
        } catch (\Exception $e) {
            return Response::json([], HttpStatusCode::BAD_REQUEST);
        }
    }
}
