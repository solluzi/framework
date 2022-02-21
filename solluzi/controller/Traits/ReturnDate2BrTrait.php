<?php
declare(strict_types=1);
namespace Solluzi\Controller\Traits;
/**
* @version		0.0.0
* @category		Action
* @package		
* @subpackage		
* @author		(name) <email@codesolluzi.com>
* @copyright	Copyright (c) 2022 Solluzi Tecnologia da Informação LTDA-ME. (https://codesolluzi.com)
* @license		https://codesolluzi.com/framework-license
*	
*	
*	
*/
trait ReturnDate2BrTrait
{
    /**
     * Transform date from Us form to Brazilian
     *
     * @param [type] $value
     * @return string
     */
    public function date2br($value, $datetime = false)
    {
        if($value){
            
            $tratado = str_replace('/', '-', $value);
            $data = new \DateTime($tratado);
            if ($datetime) {
                $result = $data->format('d/m/Y H:i:s');
                return $result;
            }
    
            $result = $data->format('d/m/Y');
            return $result;
        }
        return null;
    }
}