<?php

namespace App\Console\Cltvo;

use Illuminate\Console\GeneratorCommand;

class CLtvoBindMakeCommand extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'make:bind';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Cltvo bind class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'CltvoBind';


    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__."/Stubs/cltvo-bind.stub";
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\Http\Binds';
    }

}
