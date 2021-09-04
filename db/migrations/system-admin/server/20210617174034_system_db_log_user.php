<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class SystemDbLogUser extends AbstractMigration
{
    public function up(): void
    {
        $caminho = __DIR__ . '/sql/db_log_user.sql';
        $sql     = file_get_contents($caminho);
        $sql     = str_replace('%local_user%'  , getenv('PERMISSION_DB_USER') , $sql);
        $sql     = str_replace('%remote_user%' , getenv('LOG_DB_USER')      , $sql);
        $sql     = str_replace('%remote_pass%' , getenv('LOG_DB_PASS')      , $sql);

        $this->execute($sql);
    }

    public function down()
    {
        
    }
}
