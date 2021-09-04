<?php
namespace Fundacao\Usuario;

use ApiTester;
use Codeception\Util\HttpCode;

class ExcluirCest
{
    private $id;
    public function _before(ApiTester $I)
    {
        $this->id = file_get_contents(codecept_data_dir('usuario.txt')); 
    }

    /**
     * @depends Fundacao\Usuario\AlterarStatusCest:atualizarStatusComTokenValido
     */
    public function excluirUsuarioComTokenVencido(ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->amBearerAuthenticated(file_get_contents(codecept_data_dir('token_vencido.txt')));
        $I->sendDelete("/principal/usuario/$this->id");
        $I->seeResponseCodeIs(HttpCode::FORBIDDEN);
    }

    /**
     * @depends excluirUsuarioComTokenVencido
     */
    public function excluirUsuarioComTokenValido(ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->amBearerAuthenticated(file_get_contents(codecept_data_dir('token.txt')));
        $I->sendDelete("/principal/usuario/$this->id");
        $I->seeResponseCodeIs(HttpCode::RESET_CONTENT);
    }
}
