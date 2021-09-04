<?php
namespace Fundacao\Geral;

use ApiTester;
use Codeception\Util\HttpCode;
use Nullix\CryptoJsAes\CryptoJsAes;

class LoginCest
{
    public function _before(ApiTester $I)
    {
        
    }

    // tests
    public function logarSemUsuario(ApiTester $I)
    {
        $data = [
            'username' => '',
            'password' => '12345678'
        ];
        
        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->sendPost('/principal/login', [
            'data' => CryptoJsAes::encrypt($data, getenv('CHAVE_ENCRYPT'))
        ]);
        $I->seeResponseCodeIs(HttpCode::NOT_ACCEPTABLE);
        $I->seeResponseIsJson();
    }

    /**
     * @depends logarSemUsuario
     *
     * @param ApiTester $I
     * @return void
     */
    public function logarSemSenha(ApiTester $I)
    {
        $data = [
            'username' => 'mauro.miranda',
            'password' => ''
        ];

        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->sendPost('/principal/login', [
            'data' => CryptoJsAes::encrypt($data, getenv('CHAVE_ENCRYPT'))
        ]);
        $I->seeResponseCodeIs(HttpCode::NOT_ACCEPTABLE);
        $I->seeResponseIsJson();
    }

    /**
     * @depends logarSemSenha
     *
     * @param ApiTester $I
     * @return void
     */
    public function logarComUsuarioErrado(ApiTester $I)
    {
        $data = [
            'username' => 'mauro.mirandas',
            'password' => '12345678'
        ];

        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->sendPost('/principal/login', [
            'data' => CryptoJsAes::encrypt($data, getenv('CHAVE_ENCRYPT'))
        ]);
        $I->seeResponseCodeIs(HttpCode::NO_CONTENT);
    }

    /**
     * @depends logarComUsuarioErrado
     *
     * @param ApiTester $I
     * @return void
     */
    public function logarComSenhaErrada(ApiTester $I)
    {
        $data = [
            'username' => 'mauro.miranda',
            'password' => '123456789'
        ];

        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->sendPost('/principal/login', [
            'data' => CryptoJsAes::encrypt($data, getenv('CHAVE_ENCRYPT'))
        ]);
        $I->seeResponseCodeIs(HttpCode::NO_CONTENT);
    }

    /**
     * @depends logarComSenhaErrada
     *
     * @param ApiTester $I
     * @return void
     */
    public function logarComUsuarioESenhasCertas(ApiTester $I)
    {
        $data = [
            'username' => 'mauro.miranda',
            'password' => '12345678'
        ];

        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->sendPost('/principal/login', [
            'data' => CryptoJsAes::encrypt($data, getenv('CHAVE_ENCRYPT'))
        ]);
        $I->seeResponseCodeIs(HttpCode::ACCEPTED);
        list($token) = $I->grabDataFromResponseByJsonPath('$.data.token');
        // Armazena o token
        file_put_contents(codecept_data_dir().'token.txt', $token);
    }
}
