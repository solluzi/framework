<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;
use Phinx\Util\Literal;

final class SystemUser extends AbstractMigration
{
    public function change(): void
    {
        
        $table = $this->table("SYSTEM_USER", ['id' => false]);
        $table->addColumn('ID'          , 'uuid'    , [
                'default' => Literal::from('uuid_generate_v4()'), 'null' => false
            ])
            ->addColumn('NAME'          , 'string'  , ['limit' => 100])
            ->addColumn('LOGIN'         , 'string'  , ['limit' => 88])
            ->addColumn('PASSWORD'      , 'string'  , ['limit' => 200])
            ->addColumn('ACTIVE'        , 'boolean')
            ->addColumn('PROGRAM_ID'    , 'uuid'    , ['null' => true])
            ->addColumn('TOKEN_RESET'   , 'text'    , ['null' => true])
            ->addColumn('CREATED_BY'    , 'uuid'    , ['null' => true])
            ->addColumn('UPDATED_BY'    , 'uuid'    , ['null' => true])
            ->addTimestamps('CREATED_AT', 'UPDATED_AT')
            ->changePrimaryKey(['ID'])
            ->addIndex(['LOGIN', 'ACTIVE'])
            ->addIndex(['LOGIN'], ['unique' => true])
            ->create();
    }
}
