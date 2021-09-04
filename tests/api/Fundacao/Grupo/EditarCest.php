<?php
namespace Fundacao\Grupo;

use ApiTester;
use Codeception\Util\HttpCode;
use Nullix\CryptoJsAes\CryptoJsAes;

class EditarCest
{
    public function _before(ApiTester $I)
    {
        $this->data = [
            'id' => file_get_contents(codecept_data_dir('grupo_usuario.txt'))
        ];
    }

    /**
     * @depends Fundacao\Grupo\CadastrarCest:cadastrarGrupoDeUsuariosComTokenCorreto
     */
    public function editarGrupoDeUsuarioComTokenVencido(ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->amBearerAuthenticated(file_get_contents(codecept_data_dir('token_vencido.txt')));
        $I->sendPost("/principal/grupo/editar", [
            'data'   => CryptoJsAes::encrypt($this->data, getenv('CHAVE_ENCRYPT')),
        ]);
        $I->seeResponseCodeIs(HttpCode::FORBIDDEN);
    }

    /**
     * @depends editarGrupoDeUsuarioComTokenVencido
     *
     * @param ApiTester $I
     * @return void
     */
    public function editarGrupoDeUsuarioComTokenValido(ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->amBearerAuthenticated(file_get_contents(codecept_data_dir('token.txt')));
        $I->sendPost("/principal/grupo/editar", [
            'data'   => CryptoJsAes::encrypt($this->data, getenv('CHAVE_ENCRYPT')),
        ]);
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
    }
}
