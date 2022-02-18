<?php
declare(strict_types=1);
namespace Solluzi\Psr\Logger;

use InvalidArgumentException;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;

/**
* @version		1.1.1
* @category		Psr
* @package		Solluzi
* @subpackage	Logger	
* @author		Mauro Joaquim Miranda <mauro.miranda@codesolluzi.com>
* @copyright	Copyright (c) 2022 Solluzi Tecnologia da Informação LTDA-ME. (https://codesolluzi.com)
* @license		https://codesolluzi.com/framework-license
*	
*	
*	
*	
*/
class FileLogger extends LogLevel implements LoggerInterface
{
    private $handle;

    public function __construct()
    {
        $this->handle = fopen(dirname($_SERVER['DOCUMENT_ROOT'],1).'/storage/'.date('Y-m-d').'.log', 'a+');
    }

    public function __destruct()
    {
        fclose($this->handle);
    }

    public function emergency($message, array $context = array())
    {
        $this->log(self::EMERGENCY, $message, $context);
    }

    public function alert($message, array $context = array())
    {
        $this->log(self::ALERT, $message, $context);
    }

    public function critical($message, array $context = array())
    {
        $this->log(self::CRITICAL, $message, $context);
    }

    public function error($message, array $context = array())
    {
        $this->log(self::ERROR, $message, $context);
    }

    public function warning($message, array $context = array())
    {
        $this->log(self::WARNING, $message, $context);
    }

    public function notice($message, array $context = array())
    {
        $this->log(self::NOTICE, $message, $context);
    }

    public function info($message, array $context = array())
    {
        $this->log(self::INFO, $message, $context);
    }

    public function debug($message, array $context = array())
    {
        $this->log(self::DEBUG, $message, $context);
    }

    public function log($level, $message, array $context = array())
    {
        if($level !== self::EMERGENCY &&
           $level !== self::ALERT &&
           $level !== self::CRITICAL &&
           $level !== self::ERROR &&
           $level !== self::WARNING &&
           $level !== self::NOTICE &&
           $level !== self::INFO &&
           $level !== self::DEBUG
        ) {
            throw new InvalidArgumentException("Log level invalid");
        }

        $newMessage = $message;

        foreach($context as $key => $val){
            $newMessage = str_replace('{'.$key.'}', $val, $newMessage);
        }

        $log = sprintf("%s [%s] - %s", date('Y-m-d H:s:i'), strtoupper($level), $newMessage.PHP_EOL);
        fwrite($this->handle, $log);
    }
}