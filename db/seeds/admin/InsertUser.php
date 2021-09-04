<?php


use Phinx\Seed\AbstractSeed;

class InsertUser extends AbstractSeed
{
    public function run()
    {
        $sql = dirname(__DIR__).'/admin/sql/InsertUser.sql';
        $this->execute(file_get_contents($sql));
    }
}
