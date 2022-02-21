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
use Admin\Model\GroupProgram;
use Admin\Model\UserGroup;
use Admin\Traits\AclTrait;
use Solluzi\Controller\AbstractController;
use Solluzi\Controller\Form;
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
            $grupoModel        = new Group();
            $groupProgramModel = new GroupProgram();
            $userGroupModel    = new UserGroup();


            // Campo para filtro
            $filterById       = $uriParams['id'] ?? null;

            $resultados = $grupoModel->database('system')
                ->select('g', ['g."ID" id', 'g."NAME" "name"'])
                ->where('"ID"', $request->getQueryParam('id'), '=')
                ->get();

            // Buscar Programas
            $resultadoProgramas = $groupProgramModel->database('system')
                ->select('gp', ['gp."PROGRAM_ID" id'])
                ->where('"GROUP_ID"', $request->getQueryParam('id'))
                ->getAll();

            $trataProgramas = [];
            foreach ($resultadoProgramas as $programas) {
                $trataProgramas[] = $programas->id;
            }

            // Buscar Usuarios
            $resultadoUsuarios = $userGroupModel->database('system')
                ->select('ug', ['ug."USER_ID" id'])
                ->where('ug."GROUP_ID"', $request->getQueryParam('id'))
                ->getAll();

            $trataUsuarios = [];
            foreach ($resultadoUsuarios as $usuarios) {
                $trataUsuarios[] = $usuarios->id;
            }


            // Fomatação de registros
            $resposta = [
                'records'  => $resultados,
                'programs' => $trataProgramas,
                'users'    => $trataUsuarios
            ];

            $payload = ['data' => $this->encrypt($resposta)];

            $this->response(HttpStatusCode::OK, $payload);
        } catch (\Exception $e) {
            $this->logger->emergency($e->getMessage());
            $this->response(HttpStatusCode::BAD_REQUEST);
        }
    }
}
