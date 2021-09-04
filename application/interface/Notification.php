<?php
declare(strict_types=1);
namespace Application\Interface;

interface Notification
{
    public function send(string $email, string $message);
}