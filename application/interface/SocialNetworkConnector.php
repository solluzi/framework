<?php
declare(strict_types=1);
namespace Application\Interface;

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