<?php
namespace Fundacao\Configuracao;

use ApiTester;
use Codeception\Util\HttpCode;
use Nullix\CryptoJsAes\CryptoJsAes;

class CriarCest
{
    private $data;
    public function _before(ApiTester $I)
    {
        $this->data = [
            'chave' => 'EMPRESA',
            'tipo'  => 'INFO',
            'ativo' => true,
            'data'  => [
                'NOME'     => 'SOLLUZI TECNOLOGIA',
                'TELEFONE' => '41999999999'
            ]
        ];
    }

    // tests
    public function cadastrarConfiguracoesComTokenVencido(ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->amBearerAuthenticated(file_get_contents(codecept_data_dir('token_vencido.txt')));
        $I->sendPost("/principal/configuracao", [
            'data' => CryptoJsAes::encrypt($this->data, getenv('CHAVE_ENCRYPT'))
        ]);
        $I->seeResponseCodeIs(HttpCode::FORBIDDEN);
    }

    /**
     * @depends cadastrarConfiguracoesComTokenVencido
     *
     * @param ApiTester $I
     * @return void
     */
    public function cadastrarConfiguracoesComTokenCorreto(ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->amBearerAuthenticated(file_get_contents(codecept_data_dir('token.txt')));
        $I->sendPost("/principal/configuracao", [
            'data' => CryptoJsAes::encrypt($this->data, getenv('CHAVE_ENCRYPT'))
        ]);
        $I->seeResponseCodeIs(HttpCode::CREATED);
        list($id) = $I->grabDataFromResponseByJsonPath('$.data.id');
        // Armazena o token
        file_put_contents(codecept_data_dir('configuracao.txt'), $id);
    }
}
