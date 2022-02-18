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

namespace Admin\Controllers\Security;

use Admin\Model\Acl as ModelAcl;
use Solluzi\Interfaces\Middleware;
use Solluzi\Lib\Controller\HttpStatusCode;
use Solluzi\Lib\Controller\Response;
use Solluzi\Lib\Util\Session\Session;

class Acl implements Middleware
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
