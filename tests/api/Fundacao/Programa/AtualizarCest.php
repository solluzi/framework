<?php
namespace Fundacao\Programa;

use ApiTester;
use Codeception\Util\HttpCode;
use Nullix\CryptoJsAes\CryptoJsAes;

class AtualizarCest
{
    private $data;
    private $id;
    public function _before(ApiTester $I)
    {
        $grupo = file_get_contents(codecept_data_dir('grupo_usuario.txt'));
        $this->data = [
            "id"          => "",
            "secao"       => "9c37a800-d8bc-47af-acd1-28662a9ec907",
            "icone"       => "",
            "url"         => "principal/testes",
            "controlador" => "Testes\\Controllers\\Programa\\Cadastrar::class",
            "nome"        => "teste4.controlador",
            "privado"     => "true",
            "descricao"   => "controladoresz de testes",
            "acao"        => "POST",
            "grupos"      => [
                "0"=> $grupo
            ]
        ];
        $this->id = file_get_contents(codecept_data_dir('controlador.txt')); 
    }

    /**
     * @depends Fundacao\Programa\EditarCest:editarProgramaComTokenValido
     */
    public function atualizarProgramaComTokenVencido(ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->amBearerAuthenticated(file_get_contents(codecept_data_dir('token_vencido.txt')));
        $I->sendPut("/principal/programa/$this->id", [
            'data' => CryptoJsAes::encrypt($this->data, getenv('CHAVE_ENCRYPT'))
        ]);
        $I->seeResponseCodeIs(HttpCode::FORBIDDEN);
    }

    /**
     * @depends atualizarProgramaComTokenVencido
     *
     * @param ApiTester $I
     * @return void
     */
    public function atualizarProgramaComTokenValido(ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->amBearerAuthenticated(file_get_contents(codecept_data_dir('token.txt')));
        $I->sendPut("/principal/programa/$this->id", [
            'data'   => CryptoJsAes::encrypt($this->data, getenv('CHAVE_ENCRYPT')),
        ]);
        $I->seeResponseCodeIs(HttpCode::CREATED);
        $I->seeResponseIsJson();
    }
}
