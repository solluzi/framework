<?php
declare(strict_types=1);
namespace Solluzi\Controller;

use InvalidArgumentException;

/**
* @version		1.1.1
* @category		Controller
* @package		Solluzi
* @subpackage	Controller	
* @author		Mauro Joaquim Miranda <mauro.miranda@codesolluzi.com>
* @copyright	Copyright (c) 2022 Solluzi Tecnologia da Informação LTDA-ME. (https://codesolluzi.com)
* @license		https://codesolluzi.com/framework-license
*	
*	
*	
*	
*/
abstract class AbstractController
{
    /**
    *--------------------------------------------------------------------------
    *								
    *--------------------------------------------------------------------------
    *
    *
    *
    */
    abstract function process(Request $request);

    /**
    *--------------------------------------------------------------------------
    *							Create Response
    *--------------------------------------------------------------------------
    *
    * @param array $data
    * @param int $code
    * @param array $headers
    * @return json
    */
    public function response(int $code, $data = [], array $headers = [])
    {
        if(!is_array($data)){
            throw new InvalidArgumentException('Argument 2 only accepts array');
        }

        
        http_response_code($code);
        header('Content-type: application/json');

        $responseText = $data;
        if(is_array($data)){
            $responseText = json_encode($data, 1);
        }
        echo $responseText;
    }

}