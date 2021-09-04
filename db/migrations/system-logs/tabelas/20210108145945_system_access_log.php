<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;
use Phinx\Util\Literal;

final class SystemAccessLog extends AbstractMigration
{
    public function change(): void
    {
        
        $table = $this->table('system_access_log', ['id' => false]);
        $table 
            ->addColumn('id', 'uuid', [
                'default' => Literal::from('uuid_generate_v4()'), 'null' => false
            ])
            ->addColumn('session'   , 'text')
            ->addColumn('key'       , 'string', ['limit' => 100])
            ->addColumn('login'     , 'text')
            ->addColumn('logged_in' , 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('logged_out', 'timestamp', ['null' => true])
            ->changePrimaryKey(['id'])
            ->addIndex(['login', 'logged_in'])
            ->create();
        
    }
}
