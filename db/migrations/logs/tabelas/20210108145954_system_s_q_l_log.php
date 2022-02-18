<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;
use Phinx\Util\Literal;

final class SystemSQLLog extends AbstractMigration
{
    public function up(): void
    {
        $table = $this->table('SYSTEM_SQL_LOG', ['id' => false]);
        $table
            ->addColumn('ID', 'uuid', [
                'default' => Literal::from('uuid_generate_v4()'), 'null' => false
            ])
            ->addColumn('USER_ID', 'uuid')
            ->addColumn('COMMAND', 'json')
            ->addColumn('CREATED_AT', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->changePrimaryKey(['ID'])
            ->addIndex(['USER_ID'])
            ->create();
        
    }

    public function down()
    {

    }
}
