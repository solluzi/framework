<?php

/**
 * @version     1.0.0
 * @category    Action
 * @package     App
 * @subpackage  User
 * @author      Mauro Joaquim Miranda
 * @copyright   Copyright (c) 2020 Solluzi Tecnologia da Informação LTDA-ME. (https://mauromiranda.dev)
 * @license     https://mauromiranda.dev/framework-license
 *
 * Delete
 *  deletes system user information
 */

declare(strict_types=1);

namespace Admin\Controllers\User;

use Admin\Model\User;
use Admin\Traits\AclTrait;
use Solluzi\Controller\AbstractController;
use Solluzi\Controller\Request;
use Solluzi\Controller\Traits\HttpStatusCode;
use Solluzi\Psr\Logger\FileLogger;

class DeleteController extends AbstractController
{
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
            // Remove o usuário
            $usuarioModel = new User();
            $usuarioModel->database('system')
                ->delete()
                ->where('"ID"', $request->getQueryParam('id'))
                ->execute();

            $this->response(HttpStatusCode::RESET_CONTENT);
        } catch (\Exception $e) {
            $this->logger->emergency($e->getMessage());
            $this->response(HttpStatusCode::BAD_REQUEST);
        }
    }
}
