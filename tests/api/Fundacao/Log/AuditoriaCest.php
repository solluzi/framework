<?php
namespace Fundacao\Log;

use ApiTester;
use Codeception\Util\HttpCode;
use Nullix\CryptoJsAes\CryptoJsAes;

class AuditoriaCest
{
    private $data;
    public function _before(ApiTester $I)
    {
        $this->data = [
            'login'       => '',
            'data_inicio' => '',
            'data_fim'    => ''
        ];
    }

    public function listarAcoesNoSistemaComVencido(ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->amBearerAuthenticated(file_get_contents(codecept_data_dir('token_vencido.txt')));
        $I->sendPost("/principal/auditoria/10/1", [
            'data'   => CryptoJsAes::encrypt($this->data, getenv('CHAVE_ENCRYPT')),
        ]);
        $I->seeResponseCodeIs(HttpCode::FORBIDDEN);
    }

    /**
     * @depends listarAcoesNoSistemaComVencido
     * @depends Fundacao\Programa\ExcluirCest:excluirProgramaComTokenValido
     * 
     * @param ApiTester $I
     * @return void
     */
    public function listarAcoesNoSistemaComValido(ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->amBearerAuthenticated(file_get_contents(codecept_data_dir('token.txt')));
        $I->sendPost("/principal/auditoria/1/10", [
            'data'   => CryptoJsAes::encrypt($this->data, getenv('CHAVE_ENCRYPT')),
        ]);
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
    }
}
