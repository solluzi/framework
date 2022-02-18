<?php

declare(strict_types=1);

namespace Solluzi\Lib\Traits;

/**
 * 
 */
trait FileDeleteTrait
{
    public function deleteFile($path)
    {
        if (is_file($path)) {
            unlink($path);
        }
    }
}
