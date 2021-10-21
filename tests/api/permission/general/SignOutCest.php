<?php
namespace permission\general;

use ApiTester;

class SignOutCest
{
    public function _before(ApiTester $I)
    {
    }

    /**
     * @depends permission\general\VerifyExecutionPermissionCest:acl
     */
    public function wrongToken(ApiTester $I)
    {
    }

    public function wrightToken(ApiTester $I)
    {
    }
}
