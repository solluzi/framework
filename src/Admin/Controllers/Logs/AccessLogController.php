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

use Admin\Model\AccessLog;
use Admin\Traits\AclTrait;
use Solluzi\Controller\AbstractController;
use Solluzi\Controller\Request;
use Solluzi\Controller\Traits\HttpStatusCode;
use Solluzi\Controller\Traits\PayloadEncryptTrait;
use Solluzi\Psr\Logger\FileLogger;

/**
 * System Access Log View Class
 * Get all history of access logs from the table
 */
class AccessLogController extends AbstractController
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

            $model = new AccessLog();

            // Total de registros
            $totalRecords = $model->database('log')
                ->select('al', ['COUNT(*) as total'])
                ->where('"LOGIN"', $request->getPost('login')->toString())
                ->between('DATE("LOGGED_IN")', [
                    $request->getPost('start')->toDate2Us(),
                    $request->getPost('end')->toDate2Us()])
                ->get();

            // Registro por página
            $limit = (int)$request->getQueryParam('by_page');

            // Quantas paginas terá na tabela?
            $pages = ceil($totalRecords->total / $limit);

            // Calcula o offset para a página
            $offset = ($request->getQueryParam('page') - 1) * $limit;
            #######################################################
            ################## FIM PAGINAÇÃO ######################
            #######################################################

            $logQuery = $model->database('log');
            $result         = $logQuery->select(
                'al',
                [
                    '"LOGIN" login',
                    '"FN_DATE2BR"("LOGGED_IN", true) as loggedin',
                    '"FN_DATE2BR"("LOGGED_OUT", true) as loggedout'
                ]
            )
            ->where('"LOGIN"', $request->getPost('login')->toString())
            ->between('DATE("LOGGED_IN")', [
                $request->getPost('start')->toDate2Us(),
                $request->getPost('end')->toDate2Us()
                ])
            ->limit($limit, $offset)
            ->orderBy('"LOGGED_OUT"', 'DESC')
            ->getAll();

            // Fomatação de registros
            $response = [
                'records'      => $result,
                'pages'        => $pages,
                'totalRecords' => $totalRecords->total
            ];

            $payload = ['data' => $this->encrypt($response)];
            $this->response(HttpStatusCode::OK, $payload);
        } catch (\Exception $e) {
            $this->logger->emergency($e->getMessage());
            $this->response(HttpStatusCode::BAD_REQUEST);
        }
    }
}
