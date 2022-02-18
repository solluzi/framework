<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class ViewSqlLog extends AbstractMigration
{
    public function change(): void
    {
        $sqlFile = __DIR__.'/sql/VW_SQL_LOG.SQL';
        $this->execute(file_get_contents($sqlFile));
    }
}
