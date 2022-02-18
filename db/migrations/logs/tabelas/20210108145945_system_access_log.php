<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;
use Phinx\Util\Literal;

final class SystemAccessLog extends AbstractMigration
{
    public function change(): void
    {
        
        $table = $this->table('SYSTEM_ACCESS_LOG', ['id' => false]);
        $table 
            ->addColumn('ID', 'uuid', [
                'default' => Literal::from('uuid_generate_v4()'), 'null' => false
            ])
            ->addColumn('SESSION'   , 'text')
            ->addColumn('KEY'       , 'string', ['limit' => 100])
            ->addColumn('LOGIN'     , 'text')
            ->addColumn('LOGGED_IN' , 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('LOGGED_OUT', 'timestamp', ['null' => true])
            ->changePrimaryKey(['ID'])
            ->addIndex(['LOGIN', 'LOGGED_IN'])
            ->create();
        
    }
}
