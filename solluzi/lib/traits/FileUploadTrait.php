<?php

declare(strict_types=1);

namespace Solluzi\Lib\Traits;

/**
 * 
 */
trait FileUploadTrait
{
    public function upload($uploaddir, $file, $filename, $name)
    {
        if ($file) 
        {
            if(!is_dir($uploaddir))
            {
                mkdir($uploaddir, 0777, true);
            }
            //chmod($uploaddir,0777);
            if(isset($file[$filename]['tmp_name']) && !empty($file[$filename]['tmp_name'])){
                $uploadfile = $uploaddir . $name;
                move_uploaded_file($file[$filename]['tmp_name'], $uploadfile);
            }
        }
    }
}
