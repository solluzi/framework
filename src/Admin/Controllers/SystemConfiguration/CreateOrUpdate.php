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

namespace Admin\Controllers\SystemConfiguration;

use Admin\Model\SystemConfiguration;
use Application\Interface\Middleware;
use Controller\HttpStatusCode;
use Controller\Response;
use Form\Form;
use Router\Request;
use Session\Session;
use Traits\PayloadEncryptTrait;

class CreateOrUpdate implements Middleware
{
    use PayloadEncryptTrait;

    private $form;
    public function __construct()
    {
        $this->form = new Form();
    }


    public function process(Request $request)
    {
        try {
            $formData = $request->getBody();

            /*
            |--------------------------------------------------------------------------
            |                          Configuration Model
            |--------------------------------------------------------------------------
            |
            | This value is the way we call a table model. This value is used when we
            | want to call a table in from te database
            |
            */

            $configurationModel = new SystemConfiguration();

            /*
            |--------------------------------------------------------------------------
            |                        Configuration Model Start
            |--------------------------------------------------------------------------
            |
            | This way you make a connection to the table, chosing the wright
            | credentials for that
            |
            */

            $configurationQueryDelete = $configurationModel->database('system');

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
                ->where('chave', $formData['chave'])
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

            if (count((array)$formData['data']) > 0) {
                /*
                |--------------------------------------------------------------------------
                |                                  validate
                |--------------------------------------------------------------------------
                |
                | validates the required input from the frontend or request
                |
                */

                $this->form->validate(
                    [
                        'chave'  => ['required' => true],
                        'tipo'   => ['required' => true]
                    ]
                );

                /*
                |--------------------------------------------------------------------------
                |                               Data Array
                |--------------------------------------------------------------------------
                |
                | Here we format all informations to be inserted e the table
                |
                */

                $active = $formData['ativo'] ? 'S' : 'N';
                $data  = [
                    'chave'      => $formData['chave'],
                    'valor'      => json_encode($formData['data']),
                    'tipo'       => $formData['tipo'],
                    'ativo'      => $active,
                    'created_by' => Session::getValue('user'),
                    'created_at' => date('Y-m-d H:i:s')
                ];

                /*
                |--------------------------------------------------------------------------
                |                                  start
                |--------------------------------------------------------------------------
                |
                | We start the table connection into the database
                |
                */

                $configurationModelInsert = $configurationModel->database('system');

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

                /*
                |--------------------------------------------------------------------------
                |                                  id
                |--------------------------------------------------------------------------
                |
                | After the information been inserted, the query retuns te inserted id
                |
                */

                $id = $configurationModelInsert->getId();
            }
            $result['id'] = $id;
            $payload = $this->encrypt($result);

            return Response::json(['data' => $payload], HttpStatusCode::OK);
        } catch (\Exception $e) {
            return Response::json([$e->getMessage()], HttpStatusCode::BAD_REQUEST);
        }
    }
}
