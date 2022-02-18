<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;
use Phinx\Util\Literal;

final class SystemGroupProgram extends AbstractMigration
{
    public function change(): void
    {
        
        $table = $this->table('SYSTEM_GROUP_PROGRAM', ['id' => false]);
        $table
            ->addColumn('ID'                , 'uuid', [
                'default' => Literal::from('uuid_generate_v4()'), 'null' => false
            ])
            ->addColumn('GROUP_ID'     , 'uuid')
            ->addColumn('PROGRAM_ID'   , 'uuid')
            ->changePrimaryKey(['ID'])
            ->addForeignKey('GROUP_ID'     , 'SYSTEM_GROUP'   , 'ID', ["delete" => "CASCADE", "update" => "NO_ACTION"])
            ->addForeignKey('PROGRAM_ID'   , 'SYSTEM_PROGRAM' , 'ID', ["delete" => "CASCADE", "update" => "NO_ACTION"])
            ->create();
        
    }
}
