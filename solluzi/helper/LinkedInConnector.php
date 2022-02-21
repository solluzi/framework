<?php
declare(strict_types=1);
namespace App\Helper;

use Solluzi\Interfaces\SocialNetworkConnector;

/**
 * Implementa a API do linkedIn
 */
class LinkedInConnector implements SocialNetworkConnector
{
    private $email, $password;

    public function __construct(string $email, string $password)
    {
        $this->email    = $email;
        $this->password = $password;
    }

    public function login(): void
    {
        echo "Send HTTP request to log in user $this->email with ".
            "password $this->password\n";
    }

    public function logOut(): void
    {
        echo "send HTTP API request to log out user $this->email\n";
    }

    public function createPost($content): void
    {
        echo "Send HTTP API requests to create a post in LinkedIn timeline.\n";
    }
}