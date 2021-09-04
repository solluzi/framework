<?php
declare(strict_types=1);

namespace Session;

/**
 *
 */
final class Session
{
    public function __construct()
    {
        if(!isset($_SESSION))
            session_start();
    }

    public static function setValue($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public static function getValue($key)
    {
        return $_SESSION[$key];
    }

    public static function kill()
    {
        unset($_SESSION);
    }

    public static function clear($key)
    {
        unset($_SESSION[$key]);
        return null;
    }
}
