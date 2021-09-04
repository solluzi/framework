<?php

/**
 * @version     1.0.0
 * @author      Name <email@email.com>
 * @category    Action
 * @package     App
 * @subpackage  General
 * @license     MIT
 * @copyright   2018 Solluzi Tecnologia da informação LTD-ME.
 * classe Home
 *  This class gets information for all charts
 */

declare(strict_types=1);

namespace Admin\Controllers\SystemPublic;

use Application\Interface\Middleware as InterfaceMiddleware;
use Controller\HttpStatusCode;
use Controller\Response;

class Home implements InterfaceMiddleware
{

    public function process($request)
    {
        $message = ['data' => "SOLLUZI TECNOLOGIA DA INFORMACAO LTDA-ME"];
        return Response::json($message, HttpStatusCode::ACCEPTED);
    }
}
