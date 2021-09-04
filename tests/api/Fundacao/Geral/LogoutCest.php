<?php
namespace Fundacao\Geral;

use ApiTester;
use Codeception\Util\HttpCode;

class LogoutCest
{
    public function _before(ApiTester $I)
    {
    }

    /**
     * @depends Fundacao\Log\LogAcessoCest:listarAcoesNoSistemaComValido
     *
     * @param ApiTester $I
     * @return void
     */
    public function tentarSairDoSistemaComTokenVencido(ApiTester $I)
    {
        $I->haveHttpHeader('accept', 'application/json');
        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->amBearerAuthenticated(file_get_contents(codecept_data_dir().'token_vencido.txt'));
        $I->sendGet('/principal/logout');
        $I->canSeeResponseCodeIs(HttpCode::FORBIDDEN);
    }

    /**
     * @depends tentarSairDoSistemaComTokenVencido
     *
     * @param ApiTester $I
     * @return void
     */
    public function tentarSairDoSistemaComTokenCorreto(ApiTester $I)
    {
        $I->haveHttpHeader('accept', 'application/json');
        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->amBearerAuthenticated(file_get_contents(codecept_data_dir().'token.txt'));
        $I->sendGet('/principal/logout');
        $I->canSeeResponseCodeIs(HttpCode::ACCEPTED);
    }
}
