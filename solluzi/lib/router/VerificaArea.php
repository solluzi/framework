<?php

declare(strict_types=1);
/**
 * 
 */

namespace Router;

use Solluzi\Lib\Traits\IsLoggedinTrait;

/**
 * 
 */
trait VerificaArea
{
    use IsLoggedinTrait;
    public function verifica()
    {
        if (
            is_array($this->match)
            && is_callable($this->match['target'], true)
            && ($this->class === $this->match['target'])
            && (isset($this->controladorSelect->PRIVATE))
            && ($this->controladorSelect->PRIVATE == true)
            && ($this->verifyAccess() === 100)
        ) 
        {
            return '1';
        }

        if (is_array($this->match)
            && is_callable($this->match['target'], true) 
            && ($this->class == $this->match['target'])
            && (isset($this->controladorSelect->PRIVATE) 
            && ($this->controladorSelect->PRIVATE == false))            
        ) 
        { 
            return '2';
        }
    }
}
