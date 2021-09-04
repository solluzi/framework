<?php

declare(strict_types=1);
/**
 * 
 */

namespace Router;

use Form\Request as FormRequest;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UriInterface;
use Traits\PayloadDecryptTrait;

class Request implements ServerRequestInterface
{
    private $data;
    private $uri;
    use PayloadDecryptTrait;
    use FormRequest;

    public function getServerParams()
    {
        $this->data = $_SERVER;
        return $this;
    }

    public function getCookieParams()
    {
        return $_COOKIE;
    }

    public function withCookieParams(array $cookies)
    {
        
    }

    public function getQueryParams()
    {
        return $_GET;
    }

    public function withQueryParams(array $query)
    {
        
    }

    public function getUploadedFiles()
    {
        return $_FILES;
    }

    public function withUploadedFiles(array $uploadedFiles)
    {
        
    }

    public function getParsedBody()
    {
        
    }

    public function withParsedBody($data)
    {
        
    }

    public function getAttributes()
    {
        
    }

    public function getAttribute($name, $default = null)
    {
        
    }

    public function withAttribute($name, $value)
    {
        
    }

    public function withoutAttribute($name)
    {
        
    }

    public function getRequestTarget()
    {
        
    }

    public function withRequestTarget($requestTarget)
    {
        
    }

    public function getMethod()
    {
        
    }

    public function withMethod($method)
    {
        
    }

    public function getUri()
    {
        $this->uri = $_SERVER['REQUEST_URI'];
        return $this;
    }

    public function withUri(UriInterface $uri, $preserveHost = false)
    {
        
    }

    public function getProtocolVersion()
    {
        
    }

    public function withProtocolVersion($version)
    {
        
    }

    public function getHeaders()
    {
        
    }

    public function hasHeader($name)
    {
        
    }

    public function getHeader($name)
    {
        
    }

    public function getHeaderLine($name)
    {
        
    }

    public function withHeader($name, $value)
    {
        
    }

    public function withAddedHeader($name, $value)
    {
        
    }

    public function withoutHeader($name)
    {
        
    }

    public function getBody()
    {
        return $this->dataVerification();
    }

    public function withBody(StreamInterface $body)
    {
        
    }
}