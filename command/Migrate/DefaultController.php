<?php
declare(strict_types=1);
namespace Command\Migrate;

use Solluzi\Minicli\CommandController;

class DefaultController extends CommandController
{
    public function handle()
    {
        $output = shell_exec('vendor/bin/phinx status -c db/database/system-admin.php');
        echo "$output";
    }
   
}