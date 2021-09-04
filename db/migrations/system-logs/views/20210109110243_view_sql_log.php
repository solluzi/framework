<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class ViewSqlLog extends AbstractMigration
{
    public function change(): void
    {
        $sqlFile = __DIR__.'/sql/vw_sql_log.sql';
        $this->execute(file_get_contents($sqlFile));
    }
}
