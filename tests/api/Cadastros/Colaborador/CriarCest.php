<?php
namespace Cadastros\Colaborador;

use ApiTester;
use Codeception\Util\HttpCode;
use Fundacao\Geral\VerificaAcessoCest;
use Nullix\CryptoJsAes\CryptoJsAes;

class CriarCest
{
    private $data;
    public function _before(ApiTester $I)
    {

        $this->data = [
            'tipo'           => '1',
            'relacionamento' => 'd3a3156a-c6de-4e7c-8f7b-6361a47d2a18',
            'nome'           => 'Isabelly Marina da Costa',
            'cpf'            => '230.205.588-83',
            'rg'             => '12.603.734-6',
            // Endereco
            'cep'            => '60441-370',
            'logradouro'     => 'Travessa Júlio Ribeiro',
            'numero'         => '526',
            'complemento'    => '',
            'bairro'         => 'Demócrito Rocha',
            'cidade'         => 'Fortaleza',
            'estado'         => 'CE',
            // Telefone
            'descricao'      => 'Residencial',
            'telefone'       => '(85) 3703-0578',
            // Email         
            'email'          => 'isabellymarinadacosta_@charquesorocaba.com.br'
        ];
    }

    /**
     * @depends Fundacao\Grupo\ListarCest:listarGrupoDeUsuarioComTokenValido
     */
    public function cadastrarColaboradorComTokenErrado(ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->amBearerAuthenticated(file_get_contents(codecept_data_dir('token_vencido.txt')));
        $I->sendPost("/cadastro/colaborador", [
            'data' => CryptoJsAes::encrypt($this->data, getenv('CHAVE_ENCRYPT'))
        ]);
        $I->seeResponseCodeIs(HttpCode::FORBIDDEN);
    }
    
    /**
     * @depends cadastrarColaboradorComTokenErrado
     *
     * @param ApiTester $I
     * @return void
     */
    public function cadastrarColaboradorComTokenCorreto(ApiTester $I)
    {
        $data = [
            'tipo'           => '1',
            'relacionamento' => 'd3a3156a-c6de-4e7c-8f7b-6361a47d2a18',
            'nome'           => 'Isabelly Marina da Costa',
            'cpf'            => '230.205.588-83',
            'rg'             => '12.603.734-6',
            // Endereco
            'cep'            => '60441-370',
            'logradouro'     => 'Travessa Júlio Ribeiro',
            'numero'         => '526',
            'complemento'    => '',
            'bairro'         => 'Demócrito Rocha',
            'cidade'         => 'Fortaleza',
            'estado'         => 'CE',
            // Telefone
            'descricao'      => 'Residencial',
            'telefone'       => '(85) 3703-0578',
            // Email         
            'email'          => 'isabellymarinadacosta_@charquesorocaba.com.br'
        ];

        $I->deleteHeader('Content-Type');
        $I->amBearerAuthenticated(file_get_contents(codecept_data_dir('token.txt')));
        $I->sendPost("/cadastro/colaborador", [
            'data'   => CryptoJsAes::encrypt($data, getenv('CHAVE_ENCRYPT')),
            'imagem' => file_get_contents(codecept_data_dir('avatar.jpg')),
        ]);
        $I->seeResponseCodeIs(HttpCode::CREATED);
        $I->seeResponseIsJson();
        list($id) = $I->grabDataFromResponseByJsonPath('$.data.id');
        // Armazena o token
        file_put_contents(codecept_data_dir('colaborador.txt'), $id);
    }
}
