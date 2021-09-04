<?php
namespace Fundacao\Configuracao;

use ApiTester;
use Codeception\Util\HttpCode;
use Nullix\CryptoJsAes\CryptoJsAes;

class ListarCest
{
    private $data;
    public function _before(ApiTester $I)
    {
        $this->data = [
            'chave' => 'EMPRESA'
        ];
    }

    /**
     * @depends Fundacao\Configuracao\CriarCest:cadastrarConfiguracoesComTokenCorreto
     */
    public function listarConfiguracaoComTokenVencido(ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->amBearerAuthenticated(file_get_contents(codecept_data_dir('token_vencido.txt')));
        $I->sendPost("/principal/configuracao/1/1", [
            'data' => CryptoJsAes::encrypt($this->data, getenv('CHAVE_ENCRYPT'))
        ]);
        $I->seeResponseCodeIs(HttpCode::FORBIDDEN);
    }

    /**
     * @depends listarConfiguracaoComTokenVencido
     */
    public function listarConfiguracaoComTokenValido(ApiTester $I)
    {
        $I->amBearerAuthenticated(file_get_contents(codecept_data_dir('token.txt')));
        $I->sendPost("/principal/configuracao/1/1", [
            'data' => CryptoJsAes::encrypt($this->data, getenv('CHAVE_ENCRYPT')),
        ]);
        $I->seeResponseCodeIs(HttpCode::OK);
    }
}
