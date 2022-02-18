<?php
declare(strict_types=1);
namespace Solluzi\Lib\Traits;

trait AddressTrait
{
    public function getBrazilianAddress()
    {
        $zipcode = preg_replace("/[^0-9]/","", $this->zipcode);
        $url = "http://viacep.com.br/ws/$zipcode/xml/";
        $xml = simplexml_load_file($url);
        return $xml;
    }
}