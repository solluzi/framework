<?php
namespace Fundacao\Programa;

use ApiTester;
use Codeception\Util\HttpCode;

class ExcluirCest
{
    private $id;
    public function _before(ApiTester $I)
    {
        $this->id = file_get_contents(codecept_data_dir('controlador.txt')); 
    }

    /**
     * @depends Fundacao\Grupo\ExcluirCest:excluirGrupoDeUsuarioComTokenValido
     */
    public function excluirProgramaComTokenVencido(ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->amBearerAuthenticated(file_get_contents(codecept_data_dir('token_vencido.txt')));
        $I->sendDelete("/principal/programa/$this->id");
        $I->seeResponseCodeIs(HttpCode::FORBIDDEN);
    }

    /**
     * @depends excluirProgramaComTokenVencido
     */
    public function excluirProgramaComTokenValido(ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->amBearerAuthenticated(file_get_contents(codecept_data_dir('token.txt')));
        $I->sendDelete("/principal/programa/$this->id");
        $I->seeResponseCodeIs(HttpCode::RESET_CONTENT);
    }
}
