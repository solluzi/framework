<?php
namespace Fundacao\Usuario;

use ApiTester;
use Codeception\Util\HttpCode;
use Nullix\CryptoJsAes\CryptoJsAes;

class CadastrarCest
{
    private $data;
    public function _before(ApiTester $I)
    {
        $colaborador = file_get_contents(codecept_data_dir('colaborador.txt'));
        $entrada     = file_get_contents(codecept_data_dir('controlador.txt'));
        $grupo       = file_get_contents(codecept_data_dir('grupo_usuario.txt'));
        $this->data  = [
            "id"      => "",
            "pessoa"  => "$colaborador",
            "login"   => "usuario_testes",
            "entrada" => "$entrada",
            "ativo"   => "true",
            "grupos"  => [
                "0"=> "$grupo"
            ]
        ];
    }

    /**
     * @depends Fundacao\Programa\ListarCest:listarProgramaComTokenValido
     */
    public function cadastrarUsuarioComTokenErrado(ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->amBearerAuthenticated(file_get_contents(codecept_data_dir('token_vencido.txt')));
        $I->sendPost("/principal/usuario", [
            'data' => CryptoJsAes::encrypt($this->data, getenv('CHAVE_ENCRYPT'))
        ]);
        $I->seeResponseCodeIs(HttpCode::FORBIDDEN);
    }
    
    /**
     * @depends cadastrarUsuarioComTokenErrado
     *
     * @param ApiTester $I
     * @return void
     */
    public function cadastrarUsuarioComTokenCorreto(ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->amBearerAuthenticated(file_get_contents(codecept_data_dir('token.txt')));
        $I->sendPost("/principal/usuario", [
            'data'   => CryptoJsAes::encrypt($this->data, getenv('CHAVE_ENCRYPT')),
        ]);
        $I->seeResponseCodeIs(HttpCode::CREATED);
        $I->seeResponseIsJson();
        list($id) = $I->grabDataFromResponseByJsonPath('$.data.id');
        // Armazena o token
        file_put_contents(codecept_data_dir('usuario.txt'), $id);
    }
}
