<?php
declare(strict_types=1);
namespace Console;

use Cmd\CommandController;

class NameController extends CommandController
{
    public function run($argv)
    {
        $name = isset ($argv[2]) ? $argv[2] : "World";
        $this->getApp()->getPrinter()->display("Hello $name!!!");
    }
}