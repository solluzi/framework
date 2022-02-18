<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;
use Phinx\Util\Literal;

final class SystemConfiguration extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('SYSTEM_CONFIGURATION', ['id' => false]);
        $table
            ->addColumn('id'            , 'uuid'    , [
                'default' => Literal::from('uuid_generate_v4()'), 'null' => false
            ])
            ->addColumn('KEY'       , 'string'  , ['limit' => 50])
            ->addColumn('VALUE'     , 'json')
            ->addColumn('TYPE'      , 'string'  , ['limit' => 20])
            ->addColumn('ACTIVE'    , 'char'    , ['limit' => 1])
            ->addColumn('CREATED_BY', 'uuid')
            ->addColumn('UPDATED_BY', 'uuid'    , ['null'   => true])
            ->addTimestamps('CREATED_AT', 'UPDATED_AT')
            ->addForeignKey('CREATED_BY', 'SYSTEM_USER', 'ID', ["delete" => "RESTRICT", "update" => "NO_ACTION"])
            ->addForeignKey('UPDATED_BY', 'SYSTEM_USER', 'ID', ["delete" => "SET_NULL", "update" => "NO_ACTION"])
            ->addIndex(['TYPE', 'ACTIVE'])
            ->addIndex(['KEY'], ['unique' => true])
            ->create();
    }
}
