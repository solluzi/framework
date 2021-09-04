<?php
declare(strict_types=1);
namespace Application\Interface;

use Router\Request;

interface Middleware
{
    public function process(Request $request);
}