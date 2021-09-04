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
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     scheme="bearer"
 * )
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

            // Excluir informações antigas se existir
            $configuracaoModelDelete = new SystemConfiguration();
            $configuracaoQueryDelete = $configuracaoModelDelete->start('system');
            $configuracaoQueryDelete
                ->delete()
                ->where('chave', $formData['chave'])
                ->execute();

            if (count((array)$formData['data']) > 0) {
                // Valida formulário enviado
                $this->form->validate(
                    [
                        'chave'  => ['required' => true],
                        'tipo'   => ['required' => true]
                    ]
                );

                // Informações a serem inseridas
                $ativo = $formData['ativo'] ? 'S' : 'N';
                $data  = [
                    'chave'      => $formData['chave'],
                    'valor'      => json_encode($formData['data']),
                    'tipo'       => $formData['tipo'],
                    'ativo'      => $ativo,
                    'created_by' => Session::getValue('user'),
                    'created_at' => date('Y-m-d H:i:s')
                ];

                // Faz o cadastro das informações
                $configuracaoModelInsert = new SystemConfiguration();
                $configuracaoQueryInsert = $configuracaoModelInsert->start('system');
                $configuracaoQueryInsert
                    ->insert($data)
                    ->execute();
                $id = $configuracaoQueryInsert->getId();
            }
            $result['id'] = $id;
            $payload = $this->encrypt($result);

            return Response::json(['data' => $payload], HttpStatusCode::OK);
        } catch (\Exception $e) {
            return Response::json([$e->getMessage()], HttpStatusCode::BAD_REQUEST);
        }
    }
}
