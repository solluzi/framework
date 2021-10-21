<?php
namespace permission\general;

use ApiTester;

class VerifyExecutionPermissionCest
{
    public function _before(ApiTester $I)
    {
    }

    /**
     * @depends permission\general\SignInCest:wrongUrl
     */
    public function acl(ApiTester $I)
    {
    }
}
