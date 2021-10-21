<?php
namespace permission\general;

use ApiTester;

class ForgotPasswordCest
{
    public function _before(ApiTester $I)
    {
    }

    /**
     * @depends permission\general\SignOutCest:wrightToken
     */
    public function wrongEmail(ApiTester $I)
    {
    }

    public function wrightEmail(ApiTester $I)
    {
    }
}
