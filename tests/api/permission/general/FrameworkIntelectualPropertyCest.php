<?php
namespace permission\general;

use ApiTester;
use Codeception\Util\HttpCode;

class FrameworkIntelectualPropertyCest
{

    public function _before(ApiTester $I)
    {
        
    }

    /**
     * @depends permission\general\FrameworkStatusCest:frameworkStatus
     */
    public function propertyOf(ApiTester $I)
    {
        $I->haveHttpHeader('accept', 'application/json');
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendGet('/main/home');
        $I->seeResponseCodeIs(HttpCode::ACCEPTED);
        $I->seeResponseIsJson();
        $I->seeResponseContains('{"data":"SOLLUZI TECNOLOGIA DA INFORMACAO LTDA-ME"}');      
    }
}
