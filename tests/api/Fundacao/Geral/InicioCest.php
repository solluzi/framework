<?php
namespace Fundacao\Geral;

use ApiTester;
use Codeception\Util\HttpCode;

class InicioCest
{
    public function _before(ApiTester $I)
    {
    }

    // tests
    public function verificaIndentidade(ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application\x-www-form-urlencoded');
        $I->sendGet('/principal/inicio');
        $I->seeResponseCodeIs(HttpCode::ACCEPTED);
        $I->seeResponseIsJson();
        $I->seeResponseContains('{"data":"SOLLUZI TECNOLOGIA DA INFORMACAO LTDA-ME"}');
    }
}
