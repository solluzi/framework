<?php
namespace Fundacao\Programa;

use ApiTester;
use Codeception\Util\HttpCode;
use Nullix\CryptoJsAes\CryptoJsAes;

class EditarCest
{
    public function _before(ApiTester $I)
    {
        $this->data = [
            'id' => file_get_contents(codecept_data_dir('controlador.txt'))
        ];
    }

    /**
     * @depends Fundacao\Programa\CadastrarCest:cadastrarControladorComTokenCorreto
     */
    public function editarProgramaComTokenVencido(ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->amBearerAuthenticated(file_get_contents(codecept_data_dir('token_vencido.txt')));
        $I->sendPost("/principal/programa/editar", [
            'data'   => CryptoJsAes::encrypt($this->data, getenv('CHAVE_ENCRYPT')),
        ]);
        $I->seeResponseCodeIs(HttpCode::FORBIDDEN);
    }

    /**
     * @depends editarProgramaComTokenVencido
     *
     * @param ApiTester $I
     * @return void
     */
    public function editarProgramaComTokenValido(ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->amBearerAuthenticated(file_get_contents(codecept_data_dir('token.txt')));
        $I->sendPost("/principal/programa/editar", [
            'data'   => CryptoJsAes::encrypt($this->data, getenv('CHAVE_ENCRYPT')),
        ]);
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
    }
}
