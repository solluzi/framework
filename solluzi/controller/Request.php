<?php
declare(strict_types=1);
namespace Solluzi\Controller;
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
*	
*	
*/
class Request
{
    private $post;
    private $get;
    private $variables;

    public function __construct($headers = [], $post = [], $get = [], $variables = [], $files = [])
    {
        $this->post      = $post;
        $this->get       = $get;
        $this->variables = $variables;
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
        return $this->post;
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
        $this->post[$key];
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
        return $this->get[$key];
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

}