<?php
declare(strict_types=1);
namespace Command\Setup;

use Solluzi\Minicli\CommandController;

class MainController extends CommandController
{
    public function handle()
    {
        $output = shell_exec('vendor/bin/phinx status -c db/database/system-admin.php');
        echo "$output";
    }
   
}