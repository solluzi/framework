<?php
declare(strict_types=1);

use FastRoute\RouteCollector;
use Router\Router;
use Solluzi\Controller\Request;


/**
 * @author Mauro Joaquim Miranda <mauro.miranda@solluzi.com.br>
 * @license MIT
 * @package public
 * @copyright 2018 Solluzi Tecnologia da Informação LTDA
 */

/*
*--------------------------------------------------------------------------
*                       APPLICATION ENVIRONMENT
*--------------------------------------------------------------------------
*
* You can load different configurations depending on your
* current environment. Setting the environment also influences
* things like logging and error reporting.
*
* This can be set to anything, but default usage is:
*
*     development
*     testing
*     production
*
* NOTE: If you change these, also change the error_reporting() code below
*/
$env = getenv('SO_ENV');
define('ENVIRONMENT', isset($env) ? $env : 'production');

/*
*--------------------------------------------------------------------------
*                          ERROR REPORTING
*--------------------------------------------------------------------------
*
* Different environments will require different levels of error reporting.
* By default development will show errors but testing and live will hide them.
*
*/
switch(ENVIRONMENT)
{
    case 'development':
        error_reporting(-1);
        ini_set('display_errors', '1');
        break;
    case 'testing':
    case 'production':
        ini_set('display_errors', '0');
        if(version_compare(PHP_VERSION, '7.4', '>=')){
            error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT & ~E_USER_NOTICE & ~E_USER_DEPRECATED);
        } else {
            error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_USER_NOTICE);
        }
    default:
        header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
        echo 'The application environment is not set correctly.';
        exit(1); // EXIT_ERROR
}
/*
*--------------------------------------------------------------------------
*           COBERTURA DE TESTE DE API COM CODECEPTION
*--------------------------------------------------------------------------
*
* Quanto efetuar os testes, essa classe especificamente informa o quanto 
* de cobertura de testes há neste código, coperando para boas praticas de 
* de programação.
*
*/

if(file_exists(dirname(__DIR__,1).'/c3.php')){
    require_once dirname(__DIR__,1).'/c3.php';
}

/*
*--------------------------------------------------------------------------
*           DOMINIOS AUTORIZADOS A ACESSAR O SISTEMA
*--------------------------------------------------------------------------
*
* Deve-se fornecer via variaveis de ambiente os dominios que têm permissão
* para acessar esta api, todos os dominios devem estar seperados por (;)
* ponto e virgula
*
*/

$allowedEndpoints = explode(';', getenv('FRONTEND_URL'));

/**
*--------------------------------------------------------------------------
*                               CORS
*--------------------------------------------------------------------------
*
* quando um software externo acessa a api, o mesmo fornece uma serie de
* de regras para que o dito software tenha acesso aos dados fornecidos
* pela aplicação
*
*/

require_once dirname(__DIR__,1) . '/solluzi/lib/util/general/Header.php'; 

/*
*--------------------------------------------------------------------------
*                       REGISTRA O AUTOLOADER
*--------------------------------------------------------------------------
*
* O Composer fornece um carregador de classes gerado automaticamente e 
* conveniente para esta aplicação. precisamos utilizá-lo! Vamos 
* simplesmente chamá-lo automaticamente, desta feita não precisamos 
* carregar manualmente nossas classes.
*
*/
require dirname(__DIR__,1) . '/vendor/autoload.php';

$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {
    // ADMIN
    $r->addGroup('/main', function (RouteCollector $r) {
        $r->addRoute('GET'      , '/home'                               , Admin\Controllers\SystemPublic\Home::class);
        $r->addRoute('GET'      , '/status'                             , Admin\Controllers\SystemPublic\Status::class);
        $r->addRoute('POST'     , '/signin'                             , Admin\Controllers\SystemPublic\Login::class);
        $r->addRoute('GET'      , '/signout'                            , Admin\Controllers\SystemPublic\Logout::class);
        $r->addRoute('POST'     , '/password/reset'                     , Admin\Controllers\SystemPublic\ChangePasswordRequest::class);
        $r->addRoute('POST'     , '/password/{token}/change'            , Admin\Controllers\SystemPublic\ChangePassword::class);
        $r->addRoute('GET'      , '/acl/{controller}'                   , Admin\Controllers\SystemPublic\Acl::class);
        $r->addRoute('POST'     , '/access-log/{page:\d+}/{by_page:\d+}', Admin\Controllers\SystemLog\AccessLog::class);
        $r->addRoute('POST'     , '/audit/{page:\d+}/{by_page:\d+}'     , Admin\Controllers\SystemLog\SqlLog::class);
        $r->addRoute('POST'     , '/user'                               , Admin\Controllers\SystemUser\Create::class);
        $r->addRoute('POST'     , '/user/{page:\d+}/{by_page:\d+}'      , Admin\Controllers\SystemUser\Read::class);
        $r->addRoute('GET'      , '/user/{id}/edit'                     , Admin\Controllers\SystemUser\Edit::class);
        $r->addRoute('PUT'      , '/user/{id}/update'                   , Admin\Controllers\SystemUser\Update::class);
        $r->addRoute('DELETE'   , '/user/{id}/delete'                   , Admin\Controllers\SystemUser\Delete::class);
        $r->addRoute('GET'      , '/user/{id}/status'                   , Admin\Controllers\SystemUser\ChangeStatus::class);
        $r->addRoute('GET'      , '/profile'                            , Admin\Controllers\UserProfile\Edit::class);
        $r->addRoute('POST'     , '/profile'                            , Admin\Controllers\UserProfile\Update::class);
        $r->addRoute('POST'     , '/group'                              , Admin\Controllers\SystemGroup\Create::class);
        $r->addRoute('POST'     , '/group/{page:\d+}/{by_page:\d+}'     , Admin\Controllers\SystemGroup\Read::class);
        $r->addRoute('GET'      , '/group/{id}/edit'                    , Admin\Controllers\SystemGroup\Edit::class);
        $r->addRoute('PUT'      , '/group/{id}/update'                  , Admin\Controllers\SystemGroup\Update::class);
        $r->addRoute('DELETE'   , '/group/{id}/delete'                  , Admin\Controllers\SystemGroup\Delete::class);
        $r->addRoute('POST'     , '/group/programa'                     , Admin\Controllers\SystemGroup\GrupoEPrograma::class);
        $r->addRoute('POST'     , '/section'                            , Admin\Controllers\SystemSection\Create::class);
        $r->addRoute('POST'     , '/section/{page:\d+}/{by_page:\d+}'   , Admin\Controllers\SystemSection\Read::class);
        $r->addRoute('GET'      , '/section/{id}/edit'                  , Admin\Controllers\SystemSection\Edit::class);
        $r->addRoute('PUT'      , '/section/{id}/update'                , Admin\Controllers\SystemSection\Update::class);
        $r->addRoute('DELETE'   , '/section/{id}/delete'                , Admin\Controllers\SystemSection\Delete::class);
        $r->addRoute('POST'     , '/program'                            , Admin\Controllers\SystemProgram\Create::class);
        $r->addRoute('POST'     , '/program/{page:\d+}/{by_page:\d+}'   , Admin\Controllers\SystemProgram\Read::class);
        $r->addRoute('GET'      , '/program/{id}/edit'                  , Admin\Controllers\SystemProgram\Edit::class);
        $r->addRoute('PUT'      , '/program/{id}/update'                , Admin\Controllers\SystemProgram\Update::class);
        $r->addRoute('DELETE'   , '/program/{id}/delete'                , Admin\Controllers\SystemProgram\Delete::class);
        $r->addRoute('POST'     , '/configuration/preference'           , Admin\Controllers\SystemConfiguration\CreateOrUpdate::class);
        $r->addRoute('GET'      , '/configuration/{chave}/read'         , Admin\Controllers\SystemConfiguration\Read::class);
    });
    // OTHER DEPARTAMENTS
});

// Fetch method and URI from somewhere
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri        = $_SERVER['REQUEST_URI'];
$url        = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'];

// Strip query string (?foo=bar) and decode URI
if(false !== $pos = strpos($uri, '?')){
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo     = $dispatcher->dispatch($httpMethod, $uri);

switch($routeInfo[0])
{
    case FastRoute\Dispatcher::NOT_FOUND:
        // ... 404 Not Found
        echo 'NOT FOUND';
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        // ... 405 Method Not Allowed
        echo 'Method Not Allowed';
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = new $routeInfo[1];
        $vars    = $routeInfo[2];
        // ... call $handler with $vars
        $serverRequest = new Request($_SERVER, $_POST, $_GET, $vars, $_FILES);
        $handler->process($serverRequest);
        break;
}

/*
|--------------------------------------------------------------------------
|ROTAS DA API
|--------------------------------------------------------------------------
|
| Chama todas as rotas do sistema
|
*/
//$router = new Router;
//$router->getRoutes();

