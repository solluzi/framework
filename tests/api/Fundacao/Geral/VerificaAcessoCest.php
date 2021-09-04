<?php
namespace Fundacao\Geral;

use ApiTester;

class VerificaAcessoCest
{
    public function _before(ApiTester $I)
    {
        
    }

    // tests
    public function verificarAcessoComTokenVencido(ApiTester $I)
    {
        
    }

    /**
     * @depends verificarAcessoComTokenVencido
     * @depends Fundacao\Geral\LoginCest:logarComUsuarioESenhasCertas
     *
     * @param ApiTester $I
     * @return void
     */
    public function verificarAcessoComNovoToken(ApiTester $I)
    {

    }
}
