<?php
declare(strict_types=1);
namespace Command\Hello;

use Solluzi\Minicli\CommandController;

class NameController extends CommandController
{
    public function handle()
    {
        $name = $this->hasParam('user') ? $this->getParam('user') : 'World';
        $this->getPrinter()->display(sprintf("Hello, %s!", $name));
    }
}