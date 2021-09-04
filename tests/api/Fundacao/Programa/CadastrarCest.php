<?php
namespace Fundacao\Programa;

use ApiTester;
use Codeception\Util\HttpCode;
use Nullix\CryptoJsAes\CryptoJsAes;

class CadastrarCest
{
    private $data;
    public function _before(ApiTester $I)
    {
        $grupo = file_get_contents(codecept_data_dir('grupo_usuario.txt'));
        $this->data = [
            "id"          => "",
            "secao"       => "9c37a800-d8bc-47af-acd1-28662a9ec907",
            "icone"       => "",
            "url"         => "principal/testes",
            "controlador" => "Testes\\Controllers\\Programa\\Cadastrar::class",
            "nome"        => "teste3.controlador",
            "privado"     => "true",
            "descricao"   => "controladoresz de testes",
            "acao"        => "POST",
            "grupos"      => [
                "0"=> $grupo
            ]
        ];
    }

   /**
     * @depends Cadastros\Colaborador\ListarCest:tentarListarColaboradoresComTokenCorreto
     */
    public function cadastrarControladorComTokenErrado(ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->amBearerAuthenticated(file_get_contents(codecept_data_dir('token_vencido.txt')));
        $I->sendPost("/principal/programa", [
            'data' => CryptoJsAes::encrypt($this->data, getenv('CHAVE_ENCRYPT'))
        ]);
        $I->seeResponseCodeIs(HttpCode::FORBIDDEN);
    }
    
    /**
     * @depends cadastrarControladorComTokenErrado
     *
     * @param ApiTester $I
     * @return void
     */
    public function cadastrarControladorComTokenCorreto(ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->amBearerAuthenticated(file_get_contents(codecept_data_dir('token.txt')));
        $I->sendPost("/principal/programa", [
            'data'   => CryptoJsAes::encrypt($this->data, getenv('CHAVE_ENCRYPT')),
        ]);
        $I->seeResponseCodeIs(HttpCode::CREATED);
        $I->seeResponseIsJson();
        list($id) = $I->grabDataFromResponseByJsonPath('$.data.id');
        // Armazena o token
        file_put_contents(codecept_data_dir('controlador.txt'), $id);
    }
}
