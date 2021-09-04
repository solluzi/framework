<?php


use Phinx\Seed\AbstractSeed;

class MainSeeder extends AbstractSeed
{
    protected $seedClasses = [
        InsertProgramSection::class,
        InsertProgram::class,
        InsertUser::class,
        InsertGroups::class,
        InsertUserGroup::class,
        InsertGroupProgram::class     
    ];
    public function run()
    {
        foreach($this->seedClasses as $seedClass)
        {
            /** @var Abstracted $seeder */
            $seeder = new $seedClass;
            $seeder->setAdapter($this->getAdapter()); // To set database connection
            $seeder->run();
        }
    }
}
