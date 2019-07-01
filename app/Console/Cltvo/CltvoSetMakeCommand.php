<?php

namespace App\Console\Cltvo;

use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputOption;

class CltvoSetMakeCommand extends GeneratorCommand
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:set';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Cltvo set class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'CltvoSet';

    // /**
    //  * Execute the console command.
    //  *
    //  * @return void
    //  */
    // public function fire()
    // {
    //
    // }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        if ($this->option("setup")) {
            return __DIR__."/Stubs/cltvo-set.setup.stub";
        }
        return __DIR__."/Stubs/cltvo-set.stub";
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\Console\Cltvo\Sets';
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['setup', 's', InputOption::VALUE_NONE, 'ClvoSetUp method to overwrite'],
        ];
    }

}
