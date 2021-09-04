<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class SystemDbLogServer extends AbstractMigration
{
    public function up(): void
    {
        $caminho = __DIR__ . '/sql/db_log.sql';
        $sql     = file_get_contents($caminho);
        $sql     = str_replace('%host%'     , getenv('LOG_DB_HOST'), $sql);
        $sql     = str_replace('%port%'     , getenv('LOG_DB_PORT'), $sql);
        $sql     = str_replace('%db_name%'  , getenv('LOG_DB_NAME'), $sql);

        $this->execute($sql);
    }

    public function down()
    {
        $this->execute("DROP FUNCTION fn_insert_login");
    }
}
