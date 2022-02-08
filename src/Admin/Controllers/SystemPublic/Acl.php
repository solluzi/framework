<?php

/**
 * @version     1.0.0
 * @author      Name <email@email.com>
 * @category    Action
 * @package     App
 * @subpackage  General
 * @license     MIT
 * @copyright   2018 Solluzi Tecnologia da informação LTD-ME.
 * classe Acl
 *  This class gets information for all charts
 *
 *
 */

declare(strict_types=1);

namespace Admin\Controllers\SystemPublic;

use Admin\Model\Acl as ModelAcl;
use Application\Interface\Middleware as InterfaceMiddleware;
use Controller\HttpStatusCode;
use Controller\Response;
use Session\Session;

class Acl implements InterfaceMiddleware
{

    public function process($request)
    {
        try {
            $uriParams       = $request->getQueryParams();

            // Pesquisa usuario e permissão
            $permissaoQuery = new ModelAcl();
            $permissaoSelect = $permissaoQuery->database('system')
                ->select('a', ['1 as id'])
                ->where('nome', $uriParams['controller'])
                ->where('usuario', Session::getValue('user'))
                ->where('grupo', Session::getValue('grupo'))
                ->get();

            $permitido = (isset($permissaoSelect->id)) ? true : false;

            return Response::json(['permitido' => $permitido], HttpStatusCode::ACCEPTED);
            ;
        } catch (\Exception $e) {
            return Response::json([$e->getMessage()], HttpStatusCode::BAD_REQUEST);
        }
    }
}
