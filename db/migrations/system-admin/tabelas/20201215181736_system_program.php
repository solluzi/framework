<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;
use Phinx\Util\Literal;

final class SystemProgram extends AbstractMigration
{
    public function change(): void
    {
        
        $table = $this->table('SYSTEM_PROGRAM', ['id' => false]);
        $table
            ->addColumn('ID'            , 'uuid'    , [
                'default' => Literal::from('uuid_generate_v4()'), 'null' => false
            ])
            ->addColumn('SECTION'       , 'uuid') // Criar uma tabela só para seção
            ->addColumn('PROGRAM'       , 'string'  , ['limit'  => 200  ])
            ->addColumn('NAME'          , 'string'  , ['limit'  => 100  ])
            ->addColumn('PRIVATE'       , 'boolean' , ['default'=> false, 'comment' => '1 - Privado, 2 - Publico'  ])
            ->addColumn('DESCRIPTION'   , 'text'    , ['null'   => false])
            ->addColumn('CREATED_BY'    , 'uuid'    , ['null'   => true])
            ->addColumn('UPDATED_BY'    , 'uuid'    , ['null'   => true])
            ->addTimestamps('CREATED_AT', 'UPDATED_AT')
            ->addIndex(['SECTION', 'PROGRAM'])
            ->addIndex(['NAME'], ['unique' => true])
            ->changePrimaryKey(['ID'])
            ->addForeignKey('CREATED_BY', 'SYSTEM_USER'             , 'ID', ["delete" => "RESTRICT", "update" => "NO_ACTION"])
            ->addForeignKey('UPDATED_BY', 'SYSTEM_USER'             , 'ID', ["delete" => "RESTRICT", "update" => "NO_ACTION"])
            ->addForeignKey('SECTION'   , 'SYSTEM_PROGRAM_SECTION'  , 'ID', ["delete" => "RESTRICT", "update" => "NO_ACTION"])
            ->create();
        
    }
}
