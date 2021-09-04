<?php
namespace Fundacao\Grupo;

use ApiTester;
use Codeception\Util\HttpCode;
use Nullix\CryptoJsAes\CryptoJsAes;

class ListarCest
{
    private $data;
    public function _before(ApiTester $I)
    {
        $this->data = [
            'nome' => ''
        ];
    }

    /**
     * @depends Fundacao\Grupo\AtualizarCest:atualizarGrupoDeUsuarioComTokenValido
     */
    public function listarGrupoDeUsuarioComTokenVencido(ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->amBearerAuthenticated(file_get_contents(codecept_data_dir('token_vencido.txt')));
        $I->sendPost("/principal/grupo/10/1", [
            'data'   => CryptoJsAes::encrypt($this->data, getenv('CHAVE_ENCRYPT')),
        ]);
        $I->seeResponseCodeIs(HttpCode::FORBIDDEN);
    }

    /**
     * @depends listarGrupoDeUsuarioComTokenVencido
     *
     * @param ApiTester $I
     * @return void
     */
    public function listarGrupoDeUsuarioComTokenValido(ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->amBearerAuthenticated(file_get_contents(codecept_data_dir('token.txt')));
        $I->sendPost("/principal/grupo/1/10", [
            'data'   => CryptoJsAes::encrypt($this->data, getenv('CHAVE_ENCRYPT')),
        ]);
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
    }
}
