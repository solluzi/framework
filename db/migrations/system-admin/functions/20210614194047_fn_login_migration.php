<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class FnLoginMigration extends AbstractMigration
{
    public function up(): void
    {
        $caminho = __DIR__ . '/sql/'.getenv('PERMISSION_DB_TYPE').'/SP_LOGIN.sql';
        $sql     = file_get_contents($caminho);

        $this->execute($sql);
    }

    public function down()
    {
        $this->execute("DROP FUNCTION SP_LOGIN");
    }
}
