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

namespace Admin\Controllers\UserProfile;

use Admin\Model\Profile;
use Application\Interface\Middleware;
use Controller\HttpStatusCode;
use Controller\Response;
use Router\Request;
use Session\Session;
use Traits\PayloadEncryptTrait;

class Edit implements Middleware
{
    use PayloadEncryptTrait;


    public function process(Request $request)
    {
        try {
            // Model
            $perfilModel         = new Profile();
            /* Colunas de filtro */
            $colunas = [
                'id' ,
            ];

            $resultados = $perfilModel->database('system')
                ->select('', $colunas)
                ->where('usuario', Session::getValue('user'))
                ->get();


            // Fomatação de registros
            $resposta['data'] = [
                'registros' => $resultados
            ];

            $payload = $this->encrypt($resposta);

            return Response::json(['data' => $payload], HttpStatusCode::OK);
        } catch (\Exception $e) {
            return Response::json([], HttpStatusCode::BAD_REQUEST);
        }
    }
}
