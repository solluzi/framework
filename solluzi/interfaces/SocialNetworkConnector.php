<?php
declare(strict_types=1);
namespace Solluzi\Interfaces;

/**
 * A interface do produto declara comportamento de varios
 * produtos
 */
interface SocialNetworkConnector
{
    public function login(): void;

    public function logOut(): void;

    public function createPost($content): void;
}