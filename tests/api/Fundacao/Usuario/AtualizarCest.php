<?php
namespace Fundacao\Usuario;

use ApiTester;
use Codeception\Util\HttpCode;
use Nullix\CryptoJsAes\CryptoJsAes;

class AtualizarCest
{
    private $data;
    private $id;
    public function _before(ApiTester $I)
    {
        $colaborador = file_get_contents(codecept_data_dir('colaborador.txt'));
        $entrada     = file_get_contents(codecept_data_dir('controlador.txt'));
        $grupo       = file_get_contents(codecept_data_dir('grupo_usuario.txt'));
        $this->data  = [
            "id"      => "",
            "pessoa"  => "$colaborador",
            "senha"   => '',
            "login"   => "usuario_testesxxxxx",
            "entrada" => "$entrada",
            "ativo"   => "true",
            "grupos"  => [
                "0"=> "$grupo"
            ]
        ];
        $this->id = file_get_contents(codecept_data_dir('usuario.txt')); 
    }

    /**
     * @depends Fundacao\Usuario\EditarCest:editarUsuarioComTokenValido
     */
    public function atualizarUsuarioComTokenVencido(ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->amBearerAuthenticated(file_get_contents(codecept_data_dir('token_vencido.txt')));
        $I->sendPut("/principal/usuario/$this->id", [
            'data' => CryptoJsAes::encrypt($this->data, getenv('CHAVE_ENCRYPT'))
        ]);
        $I->seeResponseCodeIs(HttpCode::FORBIDDEN);
    }

    /**
     * @depends atualizarUsuarioComTokenVencido
     *
     * @param ApiTester $I
     * @return void
     */
    public function atualizarUsuarioComTokenValido(ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->amBearerAuthenticated(file_get_contents(codecept_data_dir('token.txt')));
        $I->sendPut("/principal/usuario/$this->id", [
            'data'   => CryptoJsAes::encrypt($this->data, getenv('CHAVE_ENCRYPT')),
        ]);
        $I->seeResponseCodeIs(HttpCode::CREATED);
        $I->seeResponseIsJson();
    }
}
