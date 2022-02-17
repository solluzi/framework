<?php
declare(strict_types=1);
namespace Solluzi\Interfaces;

use Router\Request;

interface Middleware
{
    public function process(Request $request);
}