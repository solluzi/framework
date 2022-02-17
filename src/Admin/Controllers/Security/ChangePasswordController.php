<?php

/**
 * @version     1.0.0
 * @category    Action
 * @package     App
 * @subpackage  Profile
 * @author      Mauro Joaquim Miranda
 * @copyright   Copyright (c) 2020 Solluzi Tecnologia da Informação LTDA-ME. (https://mauromiranda.dev)
 * @license     https://mauromiranda.dev/framework-license
 *
 * SystemUserPasswordReset
 *  Changes User Password
 */

declare(strict_types=1);

namespace Admin\Controllers\SystemPublic;

use Admin\Model\SystemUser;
use DateTime;
use General\BCrypt;
use Router\Request;
use Solluzi\Database\Connection;
use Solluzi\Interfaces\Middleware;
use Solluzi\Lib\Controller\HttpStatusCode;
use Solluzi\Lib\Controller\Response;
use Solluzi\Lib\Form\Form;
use Solluzi\Lib\Traits\IsLoggedinTrait;
use Solluzi\Lib\Util\Session\JWTWrapper;

class ChangePassword implements Middleware
{
    use IsLoggedinTrait;

    protected $form;
    private $conn;

    public function __construct()
    {
        $this->form = new Form();
    }


    public function process(Request $request)
    {
        try {
            $formData = $request->getBody();
            $uriParams = $request->getQueryParams();

            $this->form->validate(
                [
                    'senha' => ['required' => true, 'max' => 12]
                ]
            );

            // Pesquisa a existência do token
            $loginModel = new SystemUser();
            $result     = $loginModel->database('system')
                ->select('', ['id'])
                ->where('token_reset', $uriParams['token'])
                ->get();

            $httpResponse = HttpStatusCode::NOT_ACCEPTABLE;

            $decriptToken = (!empty(JWTWrapper::decode($uriParams['token']))) ? JWTWrapper::decode($uriParams['token']) : false;

            $tokenTime    = new DateTime();
            $agora        = new DateTime('now');
            if ($decriptToken->exp) {
                $tokenTime->setTimestamp($decriptToken->exp);
            }

            if (
                ($result) &&
                ($decriptToken->iss) &&
                ($decriptToken->aud) &&
                ($decriptToken->exp) &&
                ($tokenTime->format('Y-m-d H:i:s') > $agora->format('Y-m-d H:i:s'))
            ) {
                if (isset($result->id)) {
                    $conn = Connection::open('system');
                    $sql  = "UPDATE system_user SET token_reset=NULL, updated_by=?, updated_at=?, password=crypt(?, gen_salt('bf'))  WHERE id=?";
                    $stmt = $conn->prepare($sql);
                    $execute = [
                        $result->id,
                        date('Y-m-d H:i:s'),
                        $formData['senha'],
                        $result->id
                    ];
                    $stmt->execute($execute);

                    $httpResponse = HttpStatusCode::CREATED;
                }
            }

            return Response::json([], $httpResponse);
        } catch (\Exception $e) {
            return Response::json($e->getMessage(), HttpStatusCode::NOT_ACCEPTABLE);
        }
    }
}
