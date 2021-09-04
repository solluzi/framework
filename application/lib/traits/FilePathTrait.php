<?php

declare(strict_types=1);

namespace Traits;

/**
 * 
 */
trait FilePathTrait
{
    public function image($person)
    {
        $path = [1 => 'img/company/', 2 => 'img/user/', 3 => 'img/student/', 4 => 'img/provider/', 5 => 'img/teacher/'];
        return $path[$person];
    }

    public function courseFile($file)
    {
        $path = [1 => 'img/course/', 2 => 'files/lesson/'];
        return $path[$file];
    }

    public function arquivos($file)
    {
        $path = [1 => 'files/blog/', 2 => 'files/forum/'];
        return $path[$file];
    }
}
