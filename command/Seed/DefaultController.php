<?php
declare(strict_types=1);
namespace Command\Seed;

use Solluzi\Minicli\CommandController;

class DefaultController extends CommandController
{
    public function handle()
    {
        $output = shell_exec('vendor/bin/phinx seed:run -s MainSeeder -c db/database/admin.php');
        echo "$output";
    }
   
}