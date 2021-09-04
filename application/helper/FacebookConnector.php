<?php
declare(strict_types=1);
namespace App\Helper;

use Application\Interface\SocialNetworkConnector;

/**
 * Está Classe Implementa a API do facebook
 */
class FacebookConnector implements SocialNetworkConnector
{
    private $login, $password;

    public function __construct(string $login, string $password)
    {
        $this->login    = $login;
        $this->password = $password;
    }

    public function login(): void
    {
        echo "Send HTTP API request to log in user $this->login with ".
            "password $this->password\n";
    }

    public function logOut(): void
    {
        echo "Send HTTP API request to logout user $this->login\n";
    }

    public function createPost($content): void
    {
        echo "Send HTTP API request to create a post in facebook timeline.\n";
    }
}