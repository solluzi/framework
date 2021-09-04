<?php
namespace Fundacao\Usuario;

use ApiTester;
use Codeception\Util\HttpCode;
use Nullix\CryptoJsAes\CryptoJsAes;

class AlterarStatusCest
{
    private $data;
    private $id;
    public function _before(ApiTester $I)
    {
        $this->data = [
            'ativo' => true
        ];
        $this->id = file_get_contents(codecept_data_dir('usuario.txt'));
    }

    /**
     * @depends Fundacao\Usuario\ListarCest:listarUsuarioComTokenValido
     */
    public function atualizarStatusComTokenVencido(ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->amBearerAuthenticated(file_get_contents(codecept_data_dir('token_vencido.txt')));
        $I->sendPost("/principal/usuario/status/$this->id", [
            'data'   => CryptoJsAes::encrypt($this->data, getenv('CHAVE_ENCRYPT')),
        ]);
        $I->seeResponseCodeIs(HttpCode::FORBIDDEN);
    }

    /**
     * @depends atualizarStatusComTokenVencido
     */
    public function atualizarStatusComTokenValido(ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->amBearerAuthenticated(file_get_contents(codecept_data_dir('token.txt')));
        $I->sendPost("/principal/usuario/status/$this->id", [
            'data'   => CryptoJsAes::encrypt($this->data, getenv('CHAVE_ENCRYPT')),
        ]);
        $I->seeResponseCodeIs(HttpCode::ACCEPTED);
        $I->seeResponseIsJson();
    }
}
