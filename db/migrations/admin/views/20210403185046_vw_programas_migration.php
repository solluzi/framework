<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class VwProgramasMigration extends AbstractMigration
{
    public function change(): void
    {
        $sqlFile = dirname(__DIR__,1).'/views/sql/view_program.sql';
        $this->execute(file_get_contents($sqlFile));
    }
}
