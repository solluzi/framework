<?php

declare(strict_types=1);
/**
 * @author Name <email@email.com>
 * @license MIT
 * @package category
 * @copyright 2018 Name
 * classe Transaction
 * esta classe provê os métodos necessários para manipular a transação
 */

namespace Application\Ado;


final class Transaction
{
    private static $conn;   // conexão ativa
    private static $logger; // objeto de LOG
    private static $type;

    /**
     * método __construct()
     * Está declarado como private para impedir que se crie instancias de Transaction
     */
    private function __construct()
    { }

    /**
     * método open()
     * Abre uma transação e uma conexão ao BD
     * @param mixed $database = nome do banco de dados
     */
    public static function open($database)
    {
        // abre uma conexão e armazena na properiedade estatica $conn
        if (empty(self::$conn)) {
            self::$conn = Connection::open($database);
            // inicia a transação
            self::$conn->beginTransaction();
            // desliga o log de SQL
            self::$logger = null;
            self::$type = Connection::tipo();
            
        }
    }

    /**
     * método get()
     * retorna a conexão ativa da transação
     */
    public static function get()
    {
        // retorna a conexão ativa
        return self::$conn;
    }

    /**
     * método rollback()
     * desfaz todas as operações relizadas na transação
     */
    public static function rollback()
    {
        if (self::$conn) {
            // desfaz as operações realizadas na transação
            self::$conn->rollback();
            self::$conn = null;
        }
    }

    /**
     * método close()
     * Aplica todas as operações realizadas e fecha a transação
     */
    public static function close()
    {
        if (self::$conn) {
            // aplica as operações realizadas
            // durante a transação
            self::$conn->commit();
            self::$conn = null;
        }
    }

    /**
     * método setLogger()
     * define qual estrategia de ( algoritmo de LOG será usado )
     */
    public static function setLogger(Logger $logger)
    {
        self::$logger = $logger;
    }

    /**
     * método log()
     * armazena uma mensagem no arquivo de LOG
     * baseada na estratégia ($logger) atual
     */
    public static function log($message)
    {
        // verifica se existe um logger
        if (self::$logger) {
            self::$logger->write($message);
        }
    }

    public static function dbType()
    {
        return self::$type;
    } 
}
