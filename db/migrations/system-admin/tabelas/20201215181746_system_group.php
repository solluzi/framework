<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;
use Phinx\Util\Literal;

final class SystemGroup extends AbstractMigration
{
    public function change(): void
    {
        
        $table = $this->table('SYSTEM_GROUP', ['id' => false]);
        $table
            ->addColumn('ID'        , 'uuid'    , [
                'default' => Literal::from('uuid_generate_v4()'), 'null' => false
            ])
            ->addColumn('NAME'      , 'string'  , ['limit'  => 100, 'null' => false])
            ->addColumn('CREATED_BY', 'uuid'    , ['null'   => true])
            ->addColumn('UPDATED_BY', 'uuid'    , ['null'   => true])
            ->addTimestamps('CREATED_AT', 'UPDATED_AT')
            ->changePrimaryKey(['ID'])
            ->addIndex(['NAME'], ['unique' => true])
            ->addForeignKey('CREATED_BY', 'SYSTEM_USER', 'ID', ["delete" => "RESTRICT", "update" => "NO_ACTION"])
            ->addForeignKey('UPDATED_BY', 'SYSTEM_USER', 'ID', ["delete" => "RESTRICT", "update" => "NO_ACTION"])
            ->create();
        
    }
}
