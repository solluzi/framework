<?php
declare(strict_types=1);
use Router\Router;

/**
 * @author Mauro Joaquim Miranda <mauro.miranda@solluzi.com.br>
 * @license MIT
 * @package public
 * @copyright 2018 Solluzi Tecnologia da Informação LTDA
 */

/*
|--------------------------------------------------------------------------
|COBERTURA DE TESTE DE API COM CODECEPTION
|--------------------------------------------------------------------------
|
| Quanto efetuar os testes, essa classe especificamente informa o quanto 
| de cobertura de testes há neste código, coperando para boas praticas de 
| de programação.
|
*/

if(file_exists(dirname(__DIR__,1).'/c3.php')){
    require_once dirname(__DIR__,1).'/c3.php';
}

/*
|--------------------------------------------------------------------------
|DOMINIOS AUTORIZADOS A ACESSAR O SISTEMA
|--------------------------------------------------------------------------
|
| Deve-se fornecer via variaveis de ambiente os dominios que têm permissão
| para acessar esta api, todos os dominios devem estar seperados por (;)
| ponto e virgula
|
*/

$allowedEndpoints = explode(';', getenv('FRONTEND_URL'));

/*
|--------------------------------------------------------------------------
|CORS
|--------------------------------------------------------------------------
|
| quando um software externo acessa a api, o mesmo fornece uma serie de
| de regras para que o dito software tenha acesso aos dados fornecidos
| pela aplicação
|
*/

require_once dirname(__DIR__,1) . '/application/lib/util/general/Header.php'; 

/*
|--------------------------------------------------------------------------
| REGISTRA O AUTOLOADER
|--------------------------------------------------------------------------
|
| O Composer fornece um carregador de classes gerado automaticamente e 
| conveniente para esta aplicação. precisamos utilizá-lo! Vamos 
| simplesmente chamá-lo automaticamente, desta feita não precisamos 
| carregar manualmente nossas classes.
|
*/
require dirname(__DIR__,1) . '/vendor/autoload.php';

/*
|--------------------------------------------------------------------------
|ROTAS DA API
|--------------------------------------------------------------------------
|
| Chama todas as rotas do sistema
|
*/
$router = new Router;
$router->getRoutes();

