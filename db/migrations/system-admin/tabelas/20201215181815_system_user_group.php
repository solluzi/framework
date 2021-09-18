<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;
use Phinx\Util\Literal;

final class SystemUserGroup extends AbstractMigration
{
    public function change(): void
    {
        
        $table = $this->table('SYSTEM_USER_GROUP', ['id' => false]);
        $table
            ->addColumn('ID'                , 'uuid', [
                'default' => Literal::from('uuid_generate_v4()'), 'null' => false
            ])
            ->addColumn('USER_ID' , 'uuid')
            ->addColumn('GROUP_ID', 'uuid')
            ->changePrimaryKey(['ID'])
            ->addForeignKey('USER_ID'   , 'SYSTEM_USER' , 'ID', ["delete" => "CASCADE", "update" => "NO_ACTION"])
            ->addForeignKey('GROUP_ID'  , 'SYSTEM_GROUP', 'ID', ["delete" => "CASCADE", "update" => "NO_ACTION"])
            ->create();
        
    }
}
