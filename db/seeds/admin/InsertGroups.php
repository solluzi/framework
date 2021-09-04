<?php


use Phinx\Seed\AbstractSeed;

class InsertGroups extends AbstractSeed
{
    public function run()
    {
        $sql = dirname(__DIR__).'/admin/sql/InsertGroups.sql';
        $this->execute(file_get_contents($sql));
    }
}
