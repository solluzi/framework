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

namespace Admin\Controllers\SystemSection;

use Administracao\Model\MenuAcl;
use Application\Interface\Middleware;
use Controller\HttpStatusCode;
use Controller\Response;
use Router\Request;
use Session\Session;
use Traits\PayloadEncryptTrait;

class Acl implements Middleware
{
    use PayloadEncryptTrait;


    public function process(Request $request)
    {
        try {
            // Model
            $secaoModel = new MenuAcl();

            $usuario = Session::getValue('user');
            $grupo   = Session::getValue('grupo');

            if (empty($usuario) && empty($grupo)) {
                return HttpStatusCode::FORBIDDEN;
            }

            $listarSecao = $secaoModel->start('system')
                ->select('', ['*'])
                ->where('login', $usuario, '=')
                ->where('grupo', $grupo, '=')
                ->orderBy('secao', 'ASC')
                ->getAll();

            // Fomatação de registros
            $formataPrograma = [];
            $formataSecao    = [];
            foreach ($listarSecao as $secao) {
                $formataSecao   [$secao->secao]    = true;
                $formataPrograma[$secao->programa] = true;
            }
            $dataInfo = ['secao' => $formataSecao, 'programa' => $formataPrograma];

            $payload = $this->encrypt($dataInfo);

            return Response::json(['data' => $payload], HttpStatusCode::OK);
        } catch (\Exception $e) {
            return Response::json([], HttpStatusCode::BAD_REQUEST);
        }
    }
}
