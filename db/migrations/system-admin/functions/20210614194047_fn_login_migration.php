<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class FnLoginMigration extends AbstractMigration
{
    public function up(): void
    {
        $caminho = __DIR__ . '/sql/fn_login.sql';
        $sql     = file_get_contents($caminho);
        #$sql     = str_replace('%host%'     , getenv('DB_LOG_HOST'), $sql);
        #$sql     = str_replace('%port%'     , getenv('DB_LOG_PORT'), $sql);
        #$sql     = str_replace('%db_name%'  , getenv('DB_LOG_NAME'), $sql);
        #$sql     = str_replace('%user%'     , getenv('DB_LOG_USER'), $sql);
        #$sql     = str_replace('%senha%'    , getenv('DB_LOG_PASS'), $sql);

        $this->execute($sql);
    }

    public function down()
    {
        $this->execute("DROP FUNCTION fn_insert_login");
    }
}
