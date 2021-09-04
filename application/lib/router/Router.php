<?php

declare(strict_types=1);
/**
 * 
 */

namespace Router;

use Administracao\Model\Programa;
use AltoRouter;
use Controller\HttpStatusCode;
use Traits\IsLoggedinTrait;

class Router
{
    const AREA_PUBLICA = 1;
    const AREA_PRIVADA = 2;
    /**
     * Undocumented variable
     *
     * @var object
     */
    private $routes;
    private $match;
    private $class;
    private $params;
    private $controlador;
    private $controladorSelect;
    private $httpResponse;
    use IsLoggedinTrait;
    use VerificaArea;
    /**
     * Undocumented function
     */
    public function __construct()
    {
        $this->controlador = new Programa();
        $routeArray        = include dirname(__DIR__,3) . '/config/routes.php';
        
        $this->routes = new AltoRouter();
        $this->routes->setBasePath('');
        
        foreach ($routeArray as $key => $value) {
            
            $this->routes->addGroup('/' . $key, $value);
        }

        $this->httpResponse = HttpStatusCode::NOT_FOUND;
    }

    public function callMethod()
    {
        call_user_func_array([$this->class, 'process'], [$this->params]);
    }

    public function validate()
    {
        try{
            $this->match = $this->routes->match();
            $request = new Request;
            
            // Verifica se o controlador é publico ou privado
            $nome = $this->match['name'] ?? ' ';
            
            $controladorQuery        = $this->controlador->start('system');
            $this->controladorSelect = $controladorQuery
                ->select('p', ['p.programa', 'p.privado'])
                ->where('nome', $nome)
                ->get();
                
            // Faz tratativa da classe
            $this->class = $this->dbClass($this->controladorSelect);
            
            
            $areas = [
                self::AREA_PRIVADA,
                self::AREA_PUBLICA
            ];
            
            if(in_array($this->verifica(), $areas)){
                $_GET  = $this->match['params'] ?? null;
                $class = new $this->match['target'];
                $class->process($request);
            }

            http_response_code($this->httpResponse); 
            
               
        }catch(\Exception $e){
            http_response_code($this->httpResponse); 
        }
    }

    public function dbClass($controlador)
    {
        return isset($controlador->programa) ? str_replace('::class', '', $controlador->programa) :null;
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function getRoutes()
    {
        $this->validate();
    }
}
