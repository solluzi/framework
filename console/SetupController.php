<?php
declare(strict_types=1);
namespace Console;

use Cmd\CommandController;

class SetupController extends CommandController
{
    public function run($argv)
    {
        $output = shell_exec('vendor/bin/phinx status -c db/database/system-admin.php');
        echo "<pre>$output</pre>";
    }
}