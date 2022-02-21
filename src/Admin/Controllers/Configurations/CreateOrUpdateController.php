<?php

/**
 * @version     1.0.0
 * @category    Action
 * @package     App
 * @subpackage  Preference
 * @author      Mauro Joaquim Miranda
 * @copyright   Copyright (c) 2020 Solluzi Tecnologia da Informação LTDA-ME. (https://mauromiranda.dev)
 * @license     https://mauromiranda.dev/framework-license
 *
 * SystemPreferenceRead
 *  Gets system configuration info from the table
 *
 */

declare(strict_types=1);

namespace Admin\Controllers\Configurations;

use Admin\Model\Configuration;
use Admin\Traits\AclTrait;
use Solluzi\Controller\AbstractController;
use Solluzi\Controller\Form;
use Solluzi\Controller\Request;
use Solluzi\Controller\Traits\HttpStatusCode;
use Solluzi\Psr\Logger\FileLogger;
use Solluzi\Security\Session\Session;

class CreateOrUpdateController extends AbstractController
{
    use AclTrait;

    private $form;
    private $logger;

    public function __construct()
    {
        $this->isProtected(get_class($this));
        $this->form   = new Form();
        $this->logger = new FileLogger();
    }


    public function process(Request $request)
    {
        try {
            /*
            |--------------------------------------------------------------------------
            |                          Configuration Model
            |--------------------------------------------------------------------------
            |
            | This value is the way we call a table model. This value is used when we
            | want to call a table in from te database
            |
            */

            $model = new Configuration();

            /*
            |--------------------------------------------------------------------------
            |                        Configuration Model Start
            |--------------------------------------------------------------------------
            |
            | This way you make a connection to the table, chosing the wright
            | credentials for that
            |
            */

            $configurationQueryDelete = $model->database('system');

            /*
            |--------------------------------------------------------------------------
            |                         Delete Query Statment
            |--------------------------------------------------------------------------
            |
            | It builds a query that runs delete instruction with given parameters
            |
            */
            $configurationQueryDelete
                ->delete()
                ->where('"KEY"', $request->getPost('key')->toString())
                ->execute();

            /*
            |--------------------------------------------------------------------------
            |                              Form Data
            |--------------------------------------------------------------------------
            |
            | This variable has all inputs data, then we verify if there is some data
            | to be inserted in the table
            |
            */

            if (count((array)$request->getPost('data')) > 0) {
                /*
                |--------------------------------------------------------------------------
                |                                  validate
                |--------------------------------------------------------------------------
                |
                | validates the required input from the frontend or request
                |
                */

                $this->form->setData($request->getPosts());
                $this->form->isValid([
                    'key'  => ['required' => true],
                    'type' => ['required' => true ]
                ]);

                /*
                |--------------------------------------------------------------------------
                |                               Data Array
                |--------------------------------------------------------------------------
                |
                | Here we format all informations to be inserted e the table
                |
                */

                $active = $request->getPost('active')->toString() ? 'S' : 'N';
                $data  = [
                    '"KEY"'        => $request->getPost('key')->toString(),
                    '"VALUE"'      => json_encode($request->getPost('data')->toArray()),
                    '"TYPE"'       => $request->getPost('type')->toString(),
                    '"ACTIVE"'     => $active,
                    '"CREATED_BY"' => Session::getValue('user_id'),
                    '"CREATED_AT"' => date('Y-m-d H:i:s')
                ];

                /*
                |--------------------------------------------------------------------------
                |                                  start
                |--------------------------------------------------------------------------
                |
                | We start the table connection into the database
                |
                */

                $configurationModelInsert = $model->database('system');

                /*
                |--------------------------------------------------------------------------
                |                                  Insert
                |--------------------------------------------------------------------------
                |
                | Insert all formated information into the configuration table
                |
                */

                $configurationModelInsert
                    ->insert($data)
                    ->execute();
            }
            $this->response(HttpStatusCode::CREATED);
        } catch (\Exception $e) {
            $this->logger->emergency($e->getMessage());
            $this->response(HttpStatusCode::NOT_ACCEPTABLE);
        }
    }
}
