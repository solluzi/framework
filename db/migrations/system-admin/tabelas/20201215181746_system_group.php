<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;
use Phinx\Util\Literal;

final class SystemGroup extends AbstractMigration
{
    public function change(): void
    {
        
        $table = $this->table('system_group', ['id' => false]);
        $table
            ->addColumn('id'        , 'uuid'    , [
                'default' => Literal::from('uuid_generate_v4()'), 'null' => false
            ])
            ->addColumn('name'      , 'string'  , ['limit'  => 100, 'null' => false])
            ->addColumn('created_by', 'uuid'    , ['null'   => true])
            ->addColumn('updated_by', 'uuid'    , ['null'   => true])
            ->addTimestamps()
            ->changePrimaryKey(['id'])
            ->addIndex(['name'], ['unique' => true])
            ->addForeignKey('created_by', 'system_user', 'id', ["delete" => "RESTRICT", "update" => "NO_ACTION"])
            ->addForeignKey('updated_by', 'system_user', 'id', ["delete" => "SET_NULL", "update" => "NO_ACTION"])
            ->create();
        
    }
}
