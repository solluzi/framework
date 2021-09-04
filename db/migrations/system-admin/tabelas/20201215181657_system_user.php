<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;
use Phinx\Util\Literal;

final class SystemUser extends AbstractMigration
{
    public function change(): void
    {
        
        $table = $this->table("system_user", ['id' => false]);
        $table->addColumn('id'          , 'uuid'    , [
                'default' => Literal::from('uuid_generate_v4()'), 'null' => false
            ])
            ->addColumn('login'         , 'string'  , ['limit' => 88])
            ->addColumn('password'      , 'string'  , ['limit' => 200])
            ->addColumn('active'        , 'boolean')
            ->addColumn('program_id'    , 'uuid'    , ['null' => true])
            ->addColumn('token_reset'   , 'text'    , ['null' => true])
            ->addColumn('created_by'    , 'uuid'    , ['null' => true])
            ->addColumn('updated_by'    , 'uuid'    , ['null' => true])
            ->addTimestamps()
            ->changePrimaryKey(['id'])
            ->addIndex(['login', 'active'])
            ->addIndex(['login'], ['unique' => true])
            ->create();
        
    }
}
