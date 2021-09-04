<?php
declare(strict_types=1);
namespace Application\Interface;

/**
 * A Interface Handler declara um método para construção a cadeia de handlers
 * Também declara um metodo para executar request
 */
interface Handler
{
    public function setNext(Handler $handler): Handler;
    public function handle(array $request): ?bool;
}