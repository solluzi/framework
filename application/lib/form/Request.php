<?php

declare(strict_types=1);

namespace Form;

use Traits\PayloadDecryptTrait;

/**
 * SqlGet Trait
 *  Gets oly one result on table select
 */
trait Request
{
    use PayloadDecryptTrait;
    public function dataVerification()
    {
        $data       = json_decode(file_get_contents("php://input"));
        $formResult = ($data) ? (array)$data : $_POST;
        
        if((getenv('DATA_ENCRIPTION') === 'Y')){
            if(isset($formResult['data'])){
                $result     = $this->decrypt($formResult['data']);
                return (array)$result;
            }
            throw new \Exception('O formato dos dados enviados, estão errados!');
        }
        return $formResult;
    }
}