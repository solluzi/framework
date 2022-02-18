<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class ViewAcl extends AbstractMigration
{
    public function change(): void
    {
        $sqlFile = dirname(__DIR__).'/views/sql/view_acl.sql';
        $this->execute(file_get_contents($sqlFile));
    }
}
