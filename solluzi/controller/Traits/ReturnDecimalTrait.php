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
trait ReturnDecimalTrait
{
    /**
     * Transform date from Us form to Brazilian
     *
     * @param [type] $value
     * @return string
     */
    public function brl2decimal($brl, $decimalPlaces = 2)
    {
        // if already in USD format return as float and formated
        if(preg_match('/^\d+\.{1}\d+$/', $brl))
            return (float) number_format($brl, $decimalPlaces, '.', '');

        // remove all that is not number, point or comma
        $brl = preg_replace('/[^\d\.\,]+/', '', $brl);
        // remove point
        $decimal = str_replace('.', '', $brl);
        // change comma into point
        $decimal = str_replace(',', '.', $decimal);
        return (float) number_format((float)$decimal, $decimalPlaces, '.', '');
    }
}

//var_dump(BrlToDecimal::brl2decimal('150.99', 2)); // float(150.99)
//var_dump(BrlToDecimal::brl2decimal('10.123456789', 3)); // float(10.123)
//var_dump(BrlToDecimal::brl2decimal('R$ 10,99', 2)); // float(10.99)
//var_dump(BrlToDecimal::brl2decimal('89,999', 3)); // float(89.999)
//var_dump(BrlToDecimal::brl2decimal('1.089,90')); // float(1089.9)
//var_dump(BrlToDecimal::brl2decimal('1.089,99')); // float(1089.99)
