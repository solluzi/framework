<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;
use Phinx\Util\Literal;

final class SystemUserGroup extends AbstractMigration
{
    public function change(): void
    {
        
        $table = $this->table('system_user_group', ['id' => false]);
        $table
            ->addColumn('id'                , 'uuid', [
                'default' => Literal::from('uuid_generate_v4()'), 'null' => false
            ])
            ->addColumn('user_id' , 'uuid')
            ->addColumn('group_id', 'uuid')
            ->changePrimaryKey(['id'])
            ->addForeignKey('user_id'   , 'system_user' , 'id', ["delete" => "CASCADE", "update" => "NO_ACTION"])
            ->addForeignKey('group_id'  , 'system_group', 'id', ["delete" => "CASCADE", "update" => "NO_ACTION"])
            ->create();
        
    }
}
