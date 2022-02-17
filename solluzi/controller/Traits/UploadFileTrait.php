<?php
declare(strict_types=1);
namespace Solluzi\Controller\Traits;
/**
* @version		1.1.1
* @category		Controller
* @package		Solluzi
* @subpackage	Traits	
* @author		Mauro Joaquim Miranda <mauro.miranda@codesolluzi.com>
* @copyright	Copyright (c) 2022 Solluzi Tecnologia da Informação LTDA-ME. (https://codesolluzi.com)
* @license		https://codesolluzi.com/framework-license
*	
* 	
*	
*	
*/
trait UploadFileTrait
{
    private array $extensions;
    private string $name;
    private int $size;
    private string $destination;

    public function save()
    {
        if(!file_exists($this->getDestination())){
            mkdir($this->getDestination(), 0777, true);
        }
    }

    public function getExtension(): array
    {
        // TODO: implement method
    }

    public function setExtension($extensions = [])
    {
        // TODO: implement method
    }

    public function getName(): string
    {
        // TODO: implement method
    }

    public function setName($name)
    {
        // TODO: implement method
    }

    public function getSize(): int
    {
        // TODO: implement method
    }

    public function setSize($size)
    {
        // TODO: implement method
    }

    public function getDestination(): string
    {
        // TODO: implement method
    }

    public function setDestination($destination)
    {
        // TODO: implement method
    }

}