<?php


use Phinx\Seed\AbstractSeed;

class InsertProgram extends AbstractSeed
{
    public function run()
    {
        $sql = dirname(__DIR__).'/admin/sql/InsertProgram.sql';
        $this->execute(file_get_contents($sql));
    }
}
