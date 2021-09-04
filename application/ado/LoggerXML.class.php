<?php
declare (strict_types = 1);
/**
 * @author Name <email@email.com>
 * @package category
 * @license MIT
 * @copyright 2018 Name
 *
 * classe LoggerXML
 * implementa o algoritmo de LOG em XML
 */

namespace Application\Ado;

class LoggerXML extends Logger
{
    /**
     * método write()
     * escreve uma mensagem de arquivo de LOG
     * @param mixed $message = mensagem a ser escrita
     */
    public function write($message)
    {
        date_default_timezone_set('America/Sao_Paulo');
        $time = date('Y-m-d H:i:s');
        // monta a string
        $text = "<log>\n";
        $text .= "   <time>$time</time>\n";
        $text .= "   <message>$message</message>\n";
        $text .= "</log>\n";
        // adiciona ao final do arquivo
        $handler = fopen($this->filename, 'a');
        fwrite($handler, $text);
        fclose($handler);
    }
}
