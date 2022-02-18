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

namespace Admin\Controllers\Logs;

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
class AccessLogController implements Middleware
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
//var_dump($data);die;

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
            $login       = $data['login'] ?? null;
            $loggedin = $data['loggedin'] ?? null;
            $loggedout    = $data['loggedout'] ?? null;

            // Total de registros
            $totalRecords = $accessLogModel->database('log')
                ->select('al', ['COUNT(*) as total'])
                ->where('"LOGIN"', $login)
                ->between('DATE("LOGGED_IN")', [$loggedin, $loggedout])
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
                                        '"LOGIN" login',
                                        '"FN_DATE2BR"("LOGGED_IN", true) as loggedin',
                                        '"FN_DATE2BR"("LOGGED_OUT", true) as loggedout'
                ]
            )
                ->where('"LOGIN"', $login)
                ->between('DATE("LOGGED_IN")', [$loggedin, $loggedout])
                ->limit($limit, $offset)
                ->orderBy('"LOGGED_OUT"', 'DESC')
                ->getAll();

            // Fomatação de registros
            $response['data'] = [
                'records'      => $result,
                'pages'        => $pages,
                'totalRecords' => $totalRecords->total
            ];

            $payload = $this->encrypt($response);

            return Response::json(['data' => $payload], HttpStatusCode::OK);
        } catch (\Exception $e) {
            return Response::json([], HttpStatusCode::BAD_REQUEST);
        }
    }
}
