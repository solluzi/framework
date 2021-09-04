<?php


use Phinx\Seed\AbstractSeed;

class InsertUserGroup extends AbstractSeed
{
    public function run()
    {
        $sql = dirname(__DIR__).'/admin/sql/InsertUserGroup.sql';
        $this->execute(file_get_contents($sql));
    }
}
