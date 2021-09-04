<?php
declare(strict_types=1);
namespace App\Helper;


use Application\Abstract\SocialNetworkPoster;
use Application\Interface\SocialNetworkConnector;

/**
 * Este criador suporta o facebook. Lembrando que 
 * está classe também erda o metodo post da classe pai. 
 * Criadores concretos, são classes que o cliente usa
 */
class FacebookPoster extends SocialNetworkPoster
{
    private $login, $password;

    public function __construct(string $login, string $password)
    {
        $this->logn     = $login;
        $this->password = $password;
    }

    public function getSocialNetwork(): SocialNetworkConnector
    {
        return new FacebookConnector($this->login, $this->password);
    }
}