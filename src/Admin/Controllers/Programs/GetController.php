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

use Admin\Model\GroupProgram;
use Admin\Model\Program;
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

    public function __construct()
    {
        $this->isProtected(get_class($this));
        $this->logger = new FileLogger();
    }

    public function process(Request $request)
    {
        try {
            // Model
            $programModel      = new Program();
            $groupProgramModel = new GroupProgram();

            $resultados = $programModel->database('system')
                ->select('p', [
                    'p."ID" id',
                    'p."SECTION" section',
                    'p."NAME" "name"',
                    'p."PROGRAM" "program"',
                    'p."PRIVATE" status',
                    'p."DESCRIPTION" description'
                    ])
                ->where('"ID"', $request->getQueryParam('id'), '=')
                ->get();

            // Busca Grupos
            $resultadoGrupos = $groupProgramModel->database('system')
                ->select('gp', ['gp."GROUP_ID" as id'])
                ->where('gp."PROGRAM_ID"', $request->getQueryParam('id'), '=')
                ->getAll();

            $trataGrupo = [];
            foreach ($resultadoGrupos as $grupo) {
                $trataGrupo[] = $grupo->id;
            }

            // Fomatação de registros
            $resposta = [
                'records' => $resultados,
                'groups'  => $trataGrupo
            ];

            $payload = ['data' => $this->encrypt($resposta)];
            $this->response(HttpStatusCode::OK, $payload);
        } catch (\Exception $e) {
            $this->logger->emergency($e->getMessage());
            $this->response(HttpStatusCode::BAD_REQUEST);
        }
    }
}
