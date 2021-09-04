<?php
namespace Fundacao\Grupo;

use ApiTester;
use Codeception\Util\HttpCode;

class ExcluirCest
{
    private $id;
    public function _before(ApiTester $I)
    {
        $this->id = file_get_contents(codecept_data_dir('grupo_usuario.txt')); 
    }

    /**
     * @depends Cadastros\Colaborador\ExcluirCest:excluirColaboradorComTokenCorreto
     */
    public function excluirGrupoDeUsuarioComTokenVencido(ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->amBearerAuthenticated(file_get_contents(codecept_data_dir('token_vencido.txt')));
        $I->sendDelete("/principal/grupo/$this->id");
        $I->seeResponseCodeIs(HttpCode::FORBIDDEN);
    }

    /**
     * @depends excluirGrupoDeUsuarioComTokenVencido
     */
    public function excluirGrupoDeUsuarioComTokenValido(ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->amBearerAuthenticated(file_get_contents(codecept_data_dir('token.txt')));
        $I->sendDelete("/principal/grupo/$this->id");
        $I->seeResponseCodeIs(HttpCode::RESET_CONTENT);
    }
}
