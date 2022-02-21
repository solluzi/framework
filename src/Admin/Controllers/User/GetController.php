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

namespace Admin\Controllers\User;

use Admin\Model\User;
use Admin\Model\UserGroup;
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
            $userModel      = new User();
            $userGroupModel = new UserGroup();

            ###########################################################################
            ################ BUSCA INFORMAÇÃO DE DADO USUÁRIO PELA ID #################
            ###########################################################################
            $resultados = $userModel->database('system')
                ->select(
                    'u',
                    [
                        'u."ID" id',
                        'u."NAME" "name"',
                        'u."LOGIN" login',
                        'u."ACTIVE" status',
                        'u."PROGRAM_ID" "homePage"'
                    ]
                )
                ->where('"ID"', $request->getQueryParam('id'))
                ->get();



            ###########################################################################
            ################### BUSCA GRUPOS DE DADO USUÁRIO PELA ID ##################
            ###########################################################################
            $resultadoGrupo = $userGroupModel->database('system')
                ->select('', ['"GROUP_ID" AS id'])
                ->where('"USER_ID"', $request->getQueryParam('id'))
                ->getAll();

            $trataResultadoGrupo = [];
            foreach ($resultadoGrupo as $grupo) {
                $trataResultadoGrupo[] = $grupo->id;
            }

            // Fomatação de registros
            $resposta = [
                'records' => $resultados,
                'groups'    => $trataResultadoGrupo
            ];

            $payload = ['data' => $this->encrypt($resposta)];

            $this->response(HttpStatusCode::OK, $payload);
        } catch (\Exception $e) {
            $this->logger->emergency($e->getMessage());
            $this->response(HttpStatusCode::BAD_REQUEST);
        }
    }
}
