<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;
use Phinx\Util\Literal;

final class SystemConfiguration extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('system_configuration', ['id' => false]);
        $table
            ->addColumn('id'            , 'uuid'    , [
                'default' => Literal::from('uuid_generate_v4()'), 'null' => false
            ])
            ->addColumn('key'       , 'string'  , ['limit' => 50])
            ->addColumn('value'     , 'json')
            ->addColumn('type'      , 'string'  , ['limit' => 20])
            ->addColumn('active'    , 'char'    , ['limit' => 1])
            ->addColumn('created_by', 'uuid')
            ->addColumn('updated_by', 'uuid'    , ['null'   => true])
            ->addTimestamps()
            ->addForeignKey('created_by', 'system_user', 'id', ["delete" => "RESTRICT", "update" => "NO_ACTION"])
            ->addForeignKey('updated_by', 'system_user', 'id', ["delete" => "SET_NULL", "update" => "NO_ACTION"])
            ->addIndex(['type', 'active'])
            ->addIndex(['key'], ['unique' => true])
            ->create();
    }
}
