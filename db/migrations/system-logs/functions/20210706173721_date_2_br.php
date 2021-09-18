<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class Date2Br extends AbstractMigration
{
    public function up(): void
    {
        
        $formataData = dirname(__DIR__,3) . '/geral/'.getenv('PERMISSION_DB_TYPE').'/fn_date2br.sql';
        $this->execute(file_get_contents($formataData));
    }

    public function down()
    {
        $this->execute("DROP FUNCTION IF EXISTS fn_data2br;");
    }
}
