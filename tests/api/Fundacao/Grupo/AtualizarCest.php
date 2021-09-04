<?php
namespace Fundacao\Grupo;

use ApiTester;
use Codeception\Util\HttpCode;
use Nullix\CryptoJsAes\CryptoJsAes;

class AtualizarCest
{
    private $data;
    private $id;
    public function _before(ApiTester $I)
    {
        $this->data = [
            'nome' => 'Admins'
        ];
        $this->id = file_get_contents(codecept_data_dir('grupo_usuario.txt')); 
    }

    /**
     * @depends Fundacao\Grupo\EditarCest:editarGrupoDeUsuarioComTokenValido
     */
    public function atualizarGrupoDeUsuarioComTokenVencido(ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->amBearerAuthenticated(file_get_contents(codecept_data_dir('token_vencido.txt')));
        $I->sendPut("/principal/grupo/$this->id", [
            'data' => CryptoJsAes::encrypt($this->data, getenv('CHAVE_ENCRYPT'))
        ]);
        $I->seeResponseCodeIs(HttpCode::FORBIDDEN);
    }

    /**
     * @depends atualizarGrupoDeUsuarioComTokenVencido
     *
     * @param ApiTester $I
     * @return void
     */
    public function atualizarGrupoDeUsuarioComTokenValido(ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->amBearerAuthenticated(file_get_contents(codecept_data_dir('token.txt')));
        $I->sendPut("/principal/grupo/$this->id", [
            'data'   => CryptoJsAes::encrypt($this->data, getenv('CHAVE_ENCRYPT')),
        ]);
        $I->seeResponseCodeIs(HttpCode::CREATED);
        $I->seeResponseIsJson();
    }
}
