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
trait ReturnFloatTrait
{
    /**
     * Transform date from Us form to Brazilian
     *
     * @param [type] $value
     * @return string
     */
    public function float($value)
    {
        return number_format($value, 2);
    }
}