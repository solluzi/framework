<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;
use Phinx\Util\Literal;

final class SystemProgramSectionMigration extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('SYSTEM_PROGRAM_SECTION', ['id' => false]);
        $table 
            ->addColumn('ID'            , 'uuid'    , [
                'default' => Literal::from('uuid_generate_v4()'), 'null' => false
            ])
            ->addColumn('NAME'          , 'string'  , ['limit' => 188])
            ->addColumn('CREATED_BY'    , 'uuid'    , ['null'   => true])
            ->addColumn('UPDATED_BY'    , 'uuid'    , ['null'   => true])
            ->addTimestamps('CREATED_AT', 'UPDATED_AT')
            ->addIndex(['NAME'], ['unique' => true])
            ->changePrimaryKey(['ID'])
            ->addForeignKey('CREATED_BY', 'SYSTEM_USER', 'ID', ["delete" => "RESTRICT", "update" => "NO_ACTION"])
            ->addForeignKey('UPDATED_BY', 'SYSTEM_USER', 'ID', ["delete" => "RESTRICT", "update" => "NO_ACTION"])
            ->create();
    }
}
