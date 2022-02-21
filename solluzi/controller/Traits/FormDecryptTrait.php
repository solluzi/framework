<?php

declare(strict_types=1);

namespace Solluzi\Controller\Traits;


/**
 * SqlGet Trait
 *  Gets oly one result on table select
 */
trait FormDecript
{
    use PayloadDecryptTrait;
    public function dataVerification()
    {
        /* $data       = json_decode(file_get_contents("php://input"));
        $formResult = ($data) ? (array)$data : $_POST; */
        
        if((getenv('DATA_ENCRIPTION') === 'Y')){
            if(isset($this->post['data'])){
                $result     = $this->decrypt($this->post['data']);
                return (array)$result;
            }
            throw new \Exception('O formato dos dados enviados, estão errados!');
        }
        return $this->post;
    }
}