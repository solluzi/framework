<?php
namespace Cadastros\Colaborador;

use ApiTester;
use Codeception\Util\HttpCode;
use Nullix\CryptoJsAes\CryptoJsAes;

class ListarCest
{
    public function _before(ApiTester $I)
    {
    }

    /**
     * @depends Cadastros\Colaborador\AtualizarCest:atualizarColaboradorComTokenCorreto
     */
    public function tentarListarColaboradoresSemToken(ApiTester $I)
    {
        $data = [
            'nome'  => '',
            'email' => '',
            'cpf'   => ''
        ];
        $I->sendPost("/cadastro/colaborador/1/1", [
            'data'   => CryptoJsAes::encrypt($data, getenv('CHAVE_ENCRYPT')),
        ]);
        $I->seeResponseCodeIs(HttpCode::FORBIDDEN);
    }

    /**
     * @depends tentarListarColaboradoresSemToken
     */
    public function tentarListarColaboradoresComTokenErrado(ApiTester $I)
    {
        $data = [
            'nome'  => '',
            'email' => '',
            'cpf'   => ''
        ];
        $I->amBearerAuthenticated(file_get_contents(codecept_data_dir('token_vencido.txt')));
        $I->sendPost("/cadastro/colaborador/1/1", [
            'data'   => CryptoJsAes::encrypt($data, getenv('CHAVE_ENCRYPT')),
        ]);
        $I->seeResponseCodeIs(HttpCode::FORBIDDEN);
    }

    /**
     * @depends tentarListarColaboradoresComTokenErrado
     */

    public function tentarListarColaboradoresComTokenCorreto(ApiTester $I)
    {
        $data = [
            'nome'  => '',
            'email' => '',
            'cpf'   => ''
        ];
        $I->amBearerAuthenticated(file_get_contents(codecept_data_dir('token.txt')));
        $I->sendPost("/cadastro/colaborador/1/1", [
            'data'   => CryptoJsAes::encrypt($data, getenv('CHAVE_ENCRYPT')),
        ]);
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
    }

}
