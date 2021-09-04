<?php
namespace Cadastros\Colaborador;

use ApiTester;
use Codeception\Util\HttpCode;
use Nullix\CryptoJsAes\CryptoJsAes;

class EditarCest
{
    private $data;
    public function _before(ApiTester $I)
    {
        $this->data = [
            'id' => file_get_contents(codecept_data_dir('colaborador.txt'))
        ];
    }

    /**
     * @depends Cadastros\Colaborador\CriarCest:cadastrarColaboradorComTokenCorreto
     */
    public function editarColaboradorComTokenVencido(ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->amBearerAuthenticated(file_get_contents(codecept_data_dir('token_vencido.txt')));
        $I->sendPost("/cadastro/colaborador/editar", [
            'data'   => CryptoJsAes::encrypt($this->data, getenv('CHAVE_ENCRYPT')),
        ]);
        $I->seeResponseCodeIs(HttpCode::FORBIDDEN);
    }

    /**
     * @depends editarColaboradorComTokenVencido
     *
     * @param ApiTester $I
     * @return void
     */
    public function editarColaboradorComTokenCorreto(ApiTester $I)
    {
        $id  = file_get_contents(codecept_data_dir('colaborador.txt'));
        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->amBearerAuthenticated(file_get_contents(codecept_data_dir('token.txt')));
        $I->sendPost("/cadastro/colaborador/editar", [
            'data'   => CryptoJsAes::encrypt($this->data, getenv('CHAVE_ENCRYPT')),
        ]);
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
    }
}
