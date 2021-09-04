<?php
declare(strict_types=1);
namespace App\Helper;

use Application\Abstract\SocialNetworkPoster;
use Application\Interface\SocialNetworkConnector;

/**
 * Este Criador suporta o linkedIn
 */
class LinkedInPoster extends SocialNetworkPoster
{
    private $email, $password;

    public function __construct(string $email, string $password)
    {
        $this->email = $email;
        $this->password = $password;
    }

    public function getSocialNetwork(): SocialNetworkConnector
    {
        return new LinkedInConnector($this->email, $this->password);
    }
}