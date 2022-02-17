<?php
declare (strict_types = 1);

namespace Solluzi\Lib\General;

/**
 * BCrypt hashing class
 *
 * @author Mauro Miranda <mauro.miranda@solluzi.com.br>
 * @link http://solluzi.com.br
 */
final class BCrypt
{
    /**
     * Default salt prefix
     * @see http://www.php.net/security/crypt_blowfish.php
     * @var string
     */
    protected static $_saltPrefix = '2a';

    /**
     * Default hash cost (4-31)
     *
     * @var integer
     */
    protected static $_defaultCost = 8;

    /**
     * Salt limit length
     * @var integer
     */
    protected static $_saltLength = 22;

    /**
     * Hash a string
     *
     * @param string $string The string
     * @param integer $cost The hashing cost
     *
     * @see http://www.php.net/manual/en/function.crypt.php
     *
     * @return string
     */
    public static function hash($string, $cost = null): string
    {
        if (empty($cost)) :
            $cost = self::$_defaultCost;
        endif;

        // Salt
        $salt = self::generateRandomSalt();

        // Hash string
        $hashString = self::__generateHashString((int)$cost, $salt);
        return crypt($string, $hashString);
    }

    /**
     * Check a hashed string
     *
     * @param string $string The string
     * @param string $hash   The Hash
     *
     * @return boolean
     */
    public static function check($string, $hash)
    {
        return (crypt($string, $hash) === $hash);
    }

    /**
     * Generate a random base64 encoded salt
     *
     * @return string
     */
    public static function generateRandomSalt()
    {
        // Salt seed
        $uq = mt_rand();
        $seed = uniqid("{$uq}", true);

        // Generate salt
        $salt = base64_encode($seed);
        $salt = str_replace('+', '.', $salt);

        return substr($salt, 0, self::$_saltLength);
    }

    /**
     * Build a hash string crypt()
     *
     * @param integer $cost The hashing cost
     * @param string $salt The salt
     *
     * @return string
     */
    private static function __generateHashString($cost, $salt)
    {
        return sprintf('$%s$%02d$%s$', self::$_saltPrefix, $cost, $salt);
    }

    /**
     * Undocumented function
     *
     * @param integer $tamanho
     * @param boolean $maiusculas
     * @param boolean $minusculas
     * @param boolean $numeros
     * @param boolean $simbolos
     * @return string
     */
    public static function senha($tamanho, $maiusculas, $minusculas, $numeros, $simbolos): string
    {
        $ma = "ABCDEFGHIJKLMNOPQRSTUVYXWZ"; // $ma contem as letras maiúsculas
        $mi = "abcdefghijklmnopqrstuvyxwz"; // $mi contem as letras minusculas
        $nu = "0123456789"; // $nu contem os números
        $si = "!@#$%¨&*()_+="; // $si contem os símbolos

        $senha = null;
        if ($maiusculas) :
            // se $maiusculas for "true", a variavel $ma é embaralhada e adicionadapara variavel $senha
            $senha .= str_shuffle($ma);
        endif;

        if ($minusculas) :
            $senha .= str_shuffle($mi);
        endif;

        if ($numeros) :
            // se $numeros for "true", a variavel $nu é embaralhada e adicionada para variavel $senha
            $senha .= str_shuffle($nu);
        endif;

        if ($simbolos) :
            // se $simbolos for "true", a variavel $si é embaralhada e adicionada para a variavel $senha
            $senha .= str_shuffle($si);
        endif;

        // retorna a senha embaralhada com "str_shuffle" com o tamanho definido pela variavel $tamanho
        return substr(str_shuffle($senha), 0, $tamanho);
    }
}
