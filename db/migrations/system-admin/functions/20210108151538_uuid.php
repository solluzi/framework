<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class Uuid extends AbstractMigration
{
    
    public function change(): void
    {
        $uuid = dirname(__DIR__,3).'/geral/pgsql/uuid_extension.sql';
        $this->execute(file_get_contents($uuid));
    }
}
