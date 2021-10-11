<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class VwMenuMigration extends AbstractMigration
{
    
    public function change(): void
    {
        $sqlFile = dirname(__DIR__).'/views/sql/view_menu.sql';
        $this->execute(file_get_contents($sqlFile));
    }
}
