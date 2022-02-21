<?php
declare(strict_types=1);
namespace Solluzi\Controller;

use Solluzi\Controller\Traits\FormDecript;
use Solluzi\Controller\Traits\ReturnDate2UsTrait;

/**
* @version		1.1.1
* @category		Psr
* @package		Solluzi
* @subpackage	Controller	
* @author		Mauro Joaquim Miranda <mauro.miranda@codesolluzi.com>
* @copyright	Copyright (c) 2022 Solluzi Tecnologia da Informação LTDA-ME. (https://codesolluzi.com)
* @license		https://codesolluzi.com/framework-license
*	
*	
*/
class Request
{
    private $post;
    private $get;
    private $variables;
    private $input;
    use FormDecript;
    use ReturnDate2UsTrait;

    public function __construct($headers = [], $post = [], $get = [], $files = [])
    {
        $this->post      = $post;
        $this->get       = $get;
        $this->files     = $files;
        $this->headers   = $headers;
    }

    /**
    *--------------------------------------------------------------------------
    *								
    *--------------------------------------------------------------------------
    *
    *
    *
    */
    public function getPosts()
    {
        return $this->dataVerification();
    }

    /**
    *--------------------------------------------------------------------------
    *								
    *--------------------------------------------------------------------------
    *
    *
    *
    */
    public function getPost($key): self
    {
        $this->input = $this->dataVerification()[$key] ?? null;
        return $this;
    }

    /**
    *--------------------------------------------------------------------------
    *								
    *--------------------------------------------------------------------------
    *
    *
    *
    */
    public function getFiles()
    {

    }

    /**
    *--------------------------------------------------------------------------
    *								
    *--------------------------------------------------------------------------
    *
    *
    *
    */
    public function getFile($key)
    {

    }

    /**
    *--------------------------------------------------------------------------
    *								
    *--------------------------------------------------------------------------
    *
    *
    *
    */
    public function getFileName()
    {
        
    }

    /**
    *--------------------------------------------------------------------------
    *								
    *--------------------------------------------------------------------------
    *
    *
    *
    */
    public function getQueryParams()
    {
        return $this->get;
    }

    /**
    *--------------------------------------------------------------------------
    *								
    *--------------------------------------------------------------------------
    *
    *
    *
    */
    public function getQueryParam($key)
    {
        return $this->get[$key] ?? null;
    }

    /**
    *--------------------------------------------------------------------------
    *								
    *--------------------------------------------------------------------------
    *
    *
    *
    */
    public function getHeaders()
    {

    }

    /**
    *--------------------------------------------------------------------------
    *								
    *--------------------------------------------------------------------------
    *
    *
    *
    */
    public function toString()
    {
        return $this->input;
    }

    /**
    *--------------------------------------------------------------------------
    *								
    *--------------------------------------------------------------------------
    *
    *
    *
    */
    public function toInt()
    {

    }

    public function toDecimal()
    {

    }

    public function toDate2Us($timestamp = false)
    {
        return $this->date2us($this->input, $timestamp);
    }

    public function toDate2Br()
    {

    }

    public function toFloat()
    {

    }

    public function toBoolean()
    {
        if(is_int($this->input)){
            return $this->input;
        }
        return $this->input ? 1 : 0;
    }

    public function toBool()
    {
        if(is_int($this->input)){
            return $this->input === 1 ? true : false;
        }
        return $this->input ?? false;
    }

    public function toArray()
    {
        return (array) $this->input;
    }

}