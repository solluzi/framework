<?php

declare(strict_types=1);
/**
 * 
 */

namespace Router;

use Traits\IsLoggedinTrait;

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
            && (isset($this->controladorSelect->privado))
            && ($this->controladorSelect->privado == true)
            && ($this->verifyAccess() === 100)
        ) 
        {
            return '1';
        }

        if (is_array($this->match)
            && is_callable($this->match['target'], true) 
            && ($this->class == $this->match['target'])
            && (isset($this->controladorSelect->privado) 
            && ($this->controladorSelect->privado === false))            
        ) 
        { 
            return '2';
        }
    }
}
