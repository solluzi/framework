<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;
use Phinx\Util\Literal;

final class SystemGroupProgram extends AbstractMigration
{
    public function change(): void
    {
        
        $table = $this->table('system_group_program', ['id' => false]);
        $table
            ->addColumn('id'                , 'uuid', [
                'default' => Literal::from('uuid_generate_v4()'), 'null' => false
            ])
            ->addColumn('group_id'     , 'uuid')
            ->addColumn('program_id'   , 'uuid')
            ->changePrimaryKey(['id'])
            ->addForeignKey('group_id'     , 'system_group'   , 'id', ["delete" => "CASCADE", "update" => "NO_ACTION"])
            ->addForeignKey('program_id'   , 'system_program' , 'id', ["delete" => "CASCADE", "update" => "NO_ACTION"])
            ->create();
        
    }
}
