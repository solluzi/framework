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

namespace Admin\Controllers\Departments;

use Admin\Model\Department;
use Admin\Traits\AclTrait;
use Solluzi\Controller\AbstractController;
use Solluzi\Controller\Request;
use Solluzi\Controller\Traits\HttpStatusCode;
use Solluzi\Controller\Traits\PayloadEncryptTrait;
use Solluzi\Psr\Logger\FileLogger;

class GetController extends AbstractController
{
    use PayloadEncryptTrait;
    use AclTrait;

    private $logger;

    /**
     * Class Constructor
     */
    public function __construct()
    {
        $this->isProtected(get_class($this));

        $this->logger = new FileLogger();
    }

    public function process(Request $request)
    {
        try {
            // Model
            $secaoModel = new Department();

            $resultados = $secaoModel->database('system')
                ->select('s', ['s."ID" id', 's."NAME" "name"'])
                ->where('"ID"', $request->getQueryParam('id'))
                ->get();

            // Fomatação de registros
            $resposta = [
                'record' => $resultados,
            ];

            $payload = ['data' => $this->encrypt($resposta)];

            $this->response(HttpStatusCode::OK, $payload);
        } catch (\Exception $e) {
            $this->logger->emergency($e->getMessage());
            $this->response(HttpStatusCode::BAD_REQUEST);
        }
    }
}
