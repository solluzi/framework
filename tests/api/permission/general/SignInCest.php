<?php
namespace permission\general;

use ApiTester;

class SignInCest
{
    public function _before(ApiTester $I)
    {
    }

    /**
     * @depends permission\general\FrameworkIntelectualPropertyCest:propertyOf
     */
    public function wrongUrl(ApiTester $I)
    {
        
    }
}
