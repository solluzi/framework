<?php
namespace permission\general;

use ApiTester;
use Codeception\Util\HttpCode;

class FrameworkStatusCest
{
    public function _before(ApiTester $I)
    {
    }

    // tests
    public function tryToTest(ApiTester $I)
    {
    }

    public function frameworkStatus(ApiTester $I)
    {
        $I->haveHttpHeader('accept', 'application/json');
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendGet('/main/status');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['OK']);        
    }
}
