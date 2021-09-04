<?php

declare(strict_types=1);
/**
 * @author Name <email@email.com>
 * @package category
 * @license MIT
 * @copyright 2018 Name
 *
 * classe LoggerTXT
 * implementa o algoritmo de LOG em TXT
 */

namespace Application\Ado;

use Session\Session;

class LoggerDb extends Logger
{
    /**
     * método write()
     * escreve uma mensagem no arquivo de LOG
     *
     * @param $message = mensagem a ser escrita
     * @return void
     */
    public function write($message)
    {
        date_default_timezone_set('America/Sao_Paulo');
        $time = date("Y-m-d H:i:s");
        try {
            /* Transaction::open($this->host);
            $conn = Transaction::get();
            $stmt = $conn->prepare('INSERT INTO ' . $this->model . ' (usuario, comando, created_at) VALUES (?,?,?)');
            $json = json_encode($message);
            $values = [ Session::getValue('user'), $json, $time ];
            $stmt->execute($values);
            Transaction::close(); */
            
        } catch (\Exception $e) {
        }
    }
}
