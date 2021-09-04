<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;
use Phinx\Util\Literal;

final class SystemSQLLog extends AbstractMigration
{
    public function up(): void
    {
        $table = $this->table('system_sql_log', ['id' => false]);
        $table
            ->addColumn('id', 'uuid', [
                'default' => Literal::from('uuid_generate_v4()'), 'null' => false
            ])
            ->addColumn('user_id', 'uuid')
            ->addColumn('command', 'json')
            ->addColumn('created_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->changePrimaryKey(['id'])
            ->addIndex(['user_id'])
            ->create();
        
    }

    public function down()
    {

    }
}
