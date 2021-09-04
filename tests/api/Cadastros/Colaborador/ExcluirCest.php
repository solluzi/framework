<?php
namespace Cadastros\Colaborador;

use ApiTester;
use Codeception\Util\HttpCode;

class ExcluirCest
{
    private $id;
    public function _before(ApiTester $I)
    {
        $this->id = file_get_contents(codecept_data_dir('colaborador.txt')); 
    }

    /**
     * @depends Fundacao\Usuario\ExcluirCest:excluirUsuarioComTokenValido
     *
     * @param ApiTester $I
     * @return void
     */
    public function excluirColaboradorComTokenErrado(ApiTester $I)
    {
        $I->amBearerAuthenticated(file_get_contents(codecept_data_dir('token_vencido.txt')));
        $I->sendDelete("/cadastro/colaborador/$this->id");
        $I->seeResponseCodeIs(HttpCode::FORBIDDEN);
    }

    /**
     * @depends excluirColaboradorComTokenErrado
     *
     * @param ApiTester $I
     * @return void
     */
    public function excluirColaboradorComTokenCorreto(ApiTester $I)
    {
        $I->amBearerAuthenticated(file_get_contents(codecept_data_dir('token.txt')));
        $I->sendDelete("/cadastro/colaborador/$this->id");
        $I->seeResponseCodeIs(HttpCode::RESET_CONTENT);
    }

}
