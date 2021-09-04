<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;
use Phinx\Util\Literal;

final class SystemProgram extends AbstractMigration
{
    public function change(): void
    {
        
        $table = $this->table('system_program', ['id' => false]);
        $table
            ->addColumn('id'            , 'uuid'    , [
                'default' => Literal::from('uuid_generate_v4()'), 'null' => false
            ])
            ->addColumn('section'       , 'uuid') // Criar uma tabela só para seção
            ->addColumn('program'       , 'string'  , ['limit'  => 200  ])
            ->addColumn('name'          , 'string'  , ['limit'  => 100  ])
            ->addColumn('private'       , 'boolean' , ['default'=> false, 'comment' => '1 - Privado, 2 - Publico'  ])
            ->addColumn('description'   , 'text'    , ['null'   => false])
            ->addColumn('created_by'    , 'uuid'    , ['null'   => true])
            ->addColumn('updated_by'    , 'uuid'    , ['null'   => true])
            ->addTimestamps()
            ->addIndex(['section', 'program'])
            ->addIndex(['name'], ['unique' => true])
            ->changePrimaryKey(['id'])
            ->addForeignKey('created_by', 'system_user'             , 'id', ["delete" => "RESTRICT", "update" => "NO_ACTION"])
            ->addForeignKey('updated_by', 'system_user'             , 'id', ["delete" => "SET_NULL", "update" => "NO_ACTION"])
            ->addForeignKey('section'   , 'system_program_section'  , 'id', ["delete" => "SET_NULL", "update" => "NO_ACTION"])
            ->create();
        
    }
}
