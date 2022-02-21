<?php

declare(strict_types=1);

namespace Admin\Traits;

use Admin\Model\GroupProgram;
use Solluzi\Controller\Traits\HttpStatusCode;
use Solluzi\Psr\Logger\FileLogger;
use Solluzi\Security\Session\Session;

/**
* @version      1.1.1
* @category     Trait
* @package      Admin
* @subpackage   Traits
* @author       Mauro Joaquim Miranda <mauro.miranda@codesolluzi.com>
* @copyright    Copyright (c) 2022 Solluzi Tecnologia da Informação LTDA-ME. (https://codesolluzi.com)
* @license      https://codesolluzi.com/framework-license
*
*
*
*
*/
trait AclTrait
{
    use IsLoggedTrait;

    public function isProtected($class)
    {
        return $this->check($class);
    }

    public function check($class)
    {
        try {
            $this->checkAccess();

            $model = new GroupProgram();
            $result = $model->database('system')
                            ->select('sgp', ['COUNT(*)'])
                            ->join('"SYSTEM_PROGRAM"', 'sp', 'sp."ID"', '=', 'sgp."PROGRAM_ID"')
                            ->join('"SYSTEM_USER_GROUP"', 'sug', 'sug."GROUP_ID"', '=', 'sgp."GROUP_ID"')
                            ->where('sug."USER_ID"', Session::getValue('user_id'))
                            ->where('sug."GROUP_ID"', Session::getValue('group_id'))
                            ->where('sp."PROGRAM"', $class)
                            ->get();

            if ($result->count) {
                return;
            } else {
                http_response_code(HttpStatusCode::FORBIDDEN);
                exit;
            }
        } catch (\Exception $e) {
            $logger = new FileLogger();
            $logger->emergency($e->getMessage());
        }
    }
}
