<?php
declare(strict_types=1);

use FastRoute\RouteCollector;
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
    // MAIN
    $r->addGroup('/main', function (RouteCollector $r) {
        /*******************************************************************************************************************************/
        /*                                                         SECURITY
        /*******************************************************************************************************************************/
        $r->addRoute('GET'      , '/home'                               , Admin\Controllers\Security\HomeController::class);
        $r->addRoute('GET'      , '/status'                             , Admin\Controllers\Security\StatusController::class);
        $r->addRoute('POST'     , '/signin'                             , Admin\Controllers\Security\SignInController::class);
        $r->addRoute('GET'      , '/signout'                            , Admin\Controllers\Security\SignOutController::class);        
        /*******************************************************************************************************************************/
        /*                                                          LOGS
        /*******************************************************************************************************************************/
        $r->addRoute('POST'     , '/access-log/{page:\d+}/{by_page:\d+}', Admin\Controllers\Logs\AccessLogController::class);
        $r->addRoute('POST'     , '/audit/{page:\d+}/{by_page:\d+}'     , Admin\Controllers\Logs\SqlLogController::class);
        /*******************************************************************************************************************************/
        /*                                                          USERS
        /*******************************************************************************************************************************/
        $r->addRoute('POST'     , '/user'                               , Admin\Controllers\User\CreateController::class);
        $r->addRoute('POST'     , '/user/{page:\d+}/{by_page:\d+}'      , Admin\Controllers\User\ListController::class);
        $r->addRoute('GET'      , '/user/{id}/edit'                     , Admin\Controllers\User\GetController::class);
        $r->addRoute('PUT'      , '/user/{id}/update'                   , Admin\Controllers\User\UpdateController::class);
        $r->addRoute('DELETE'   , '/user/{id}/delete'                   , Admin\Controllers\User\DeleteController::class);
        $r->addRoute('GET'      , '/user/{id}/status'                   , Admin\Controllers\User\StatusController::class);
        /*******************************************************************************************************************************/
        /*                                                       USER PROFILE
        /*******************************************************************************************************************************/
        $r->addRoute('GET'      , '/profile'                            , Admin\Controllers\UserProfile\GetController::class);
        $r->addRoute('POST'     , '/profile'                            , Admin\Controllers\UserProfile\UpdateController::class);
        $r->addRoute('POST'     , '/profile/passrequest'                , Admin\Controllers\UserProfile\ChangePasswordController::class);
        $r->addRoute('POST'     , '/profile/{token}/newpass'            , Admin\Controllers\UserProfile\ChangePasswordController::class);
        /*******************************************************************************************************************************/
        /*                                                        USER GROUPS
        /*******************************************************************************************************************************/
        $r->addRoute('POST'     , '/group'                              , Admin\Controllers\UserGroups\CreateController::class);
        $r->addRoute('POST'     , '/group/{page:\d+}/{by_page:\d+}'     , Admin\Controllers\UserGroups\ListController::class);
        $r->addRoute('GET'      , '/group/{id}/edit'                    , Admin\Controllers\UserGroups\GetController::class);
        $r->addRoute('PUT'      , '/group/{id}/update'                  , Admin\Controllers\UserGroups\UpdateController::class);
        $r->addRoute('DELETE'   , '/group/{id}/delete'                  , Admin\Controllers\UserGroups\DeleteController::class);
        /*******************************************************************************************************************************/
        /*                                                        DEPARTMENTS
        /*******************************************************************************************************************************/
        $r->addRoute('POST'     , '/department'                         , Admin\Controllers\Departments\CreateController::class);
        $r->addRoute('POST'     , '/department/{page:\d+}/{by_page:\d+}', Admin\Controllers\Departments\ListController::class);
        $r->addRoute('GET'      , '/department/{id}/edit'               , Admin\Controllers\Departments\GetController::class);
        $r->addRoute('PUT'      , '/department/{id}/update'             , Admin\Controllers\Departments\UpdateController::class);
        $r->addRoute('DELETE'   , '/department/{id}/delete'             , Admin\Controllers\Departments\DeleteController::class);
        /*******************************************************************************************************************************/
        /*                                                         PROGRAMS
        /*******************************************************************************************************************************/
        $r->addRoute('POST'     , '/program'                            , Admin\Controllers\Programs\CreateController::class);
        $r->addRoute('POST'     , '/program/{page:\d+}/{by_page:\d+}'   , Admin\Controllers\Programs\ListController::class);
        $r->addRoute('GET'      , '/program/{id}/edit'                  , Admin\Controllers\Programs\GetController::class);
        $r->addRoute('PUT'      , '/program/{id}/update'                , Admin\Controllers\Programs\UpdateController::class);
        $r->addRoute('DELETE'   , '/program/{id}/delete'                , Admin\Controllers\Programs\DeleteController::class);
        /*******************************************************************************************************************************/
        /*                                                       INTEGRATIONS
        /*******************************************************************************************************************************/
        $r->addRoute('POST'     , '/configuration'                      , Admin\Controllers\Configurations\CreateOrUpdateController::class);
        $r->addRoute('GET'      , '/configuration/{key}/get'            , Admin\Controllers\Configurations\GetController::class);
    });
    // OTHER DEPARTAMENTS
});

// Fetch method and URI from somewhere
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri        = $_SERVER['REQUEST_URI'];
$url        = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'];

// Verify request Type
$data       = json_decode(file_get_contents("php://input"));
$formResult = ($data) ? (array)$data : $_POST;

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
        http_response_code(404);
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        // ... 405 Method Not Allowed
        echo 'Method Not Allowed';
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler       = new $routeInfo[1];
        $vars          = $routeInfo[2];
        $serverRequest = new Request($_SERVER, $formResult, $vars, $_FILES);
        $handler->process($serverRequest);
        break;
}
