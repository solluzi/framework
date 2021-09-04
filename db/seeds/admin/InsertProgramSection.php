<?php


use Phinx\Seed\AbstractSeed;

class InsertProgramSection extends AbstractSeed
{
    public function run()
    {
        $sql = dirname(__DIR__).'/admin/sql/InsertProgramSection.sql';
        $this->execute(file_get_contents($sql));
    }
}
