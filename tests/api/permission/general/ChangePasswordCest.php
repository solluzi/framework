<?php
namespace permission\general;

use ApiTester;

class ChangePasswordCest
{
    public function _before(ApiTester $I)
    {
    }

    /**
     * @depends permission\general\ForgotPasswordCest:wrightEmail
     */
    public function wrightEmail(ApiTester $I)
    {
    }
}
