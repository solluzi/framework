<?php
declare(strict_types=1);
namespace Solluzi\Interfaces;

interface Notification
{
    public function send(string $email, string $message);
}