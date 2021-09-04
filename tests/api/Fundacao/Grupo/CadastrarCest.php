<?php
namespace Fundacao\Grupo;

use ApiTester;
use Codeception\Util\HttpCode;
use Nullix\CryptoJsAes\CryptoJsAes;

class CadastrarCest
{
    private $data;
    public function _before(ApiTester $I)
    {

        $this->data = [
            'nome' => 'Admin'
        ];
    }

    
    public function cadastrarGrupoDeUsuariosComTokenErrado(ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->amBearerAuthenticated(file_get_contents(codecept_data_dir('token_vencido.txt')));
        $I->sendPost("/principal/grupo", [
            'data' => CryptoJsAes::encrypt($this->data, getenv('CHAVE_ENCRYPT'))
        ]);
        $I->seeResponseCodeIs(HttpCode::FORBIDDEN);
    }
    
    /**
     * @depends cadastrarGrupoDeUsuariosComTokenErrado
     * @depends Fundacao\Geral\VerificaAcessoCest:verificarAcessoComNovoToken
     *
     * @param ApiTester $I
     * @return void
     */
    public function cadastrarGrupoDeUsuariosComTokenCorreto(ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->amBearerAuthenticated(file_get_contents(codecept_data_dir('token.txt')));
        $I->sendPost("/principal/grupo", [
            'data'   => CryptoJsAes::encrypt($this->data, getenv('CHAVE_ENCRYPT')),
        ]);
        $I->seeResponseCodeIs(HttpCode::CREATED);
        $I->seeResponseIsJson();
        list($id) = $I->grabDataFromResponseByJsonPath('$.data.id');
        // Armazena o token
        file_put_contents(codecept_data_dir('grupo_usuario.txt'), $id);
    }
}
