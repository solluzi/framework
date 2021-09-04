<?php
declare(strict_types=1);
/**
 * @author Name <email@email.com>
 * @package category
 * @license MIT
 * @copyright 2018 Name
 *
 * classe Logger
 * Esta classe provê uma interface abstrata para definição de algoritmos de LOG
 */

namespace Application\Ado;

abstract class Logger
{
    protected $filename;   // local do arquivo de log
    /**
     * método __construct()
     * instancia um logger
     * @param mixed $filename = local do arquivo de LOG
     */
    public function __construct($filename)
    {
        $this->filename = $filename;
        // reseta o conteudo do arquivo
        file_put_contents($filename, '');
    }

    // define o método write como obrigatório
    abstract public function write($message);
}
