<?php

namespace Spatie\Fractal\Console\Commands;

use Illuminate\Console\GeneratorCommand;

class TransformerMakeCommand extends GeneratorCommand
{
    protected $name = 'make:transformer';

    protected $description = 'Create a new Fractal transformer class';

    protected $type = 'Transformer';

    protected function getStub()
    {
        return __DIR__.'/../stubs/transformer.stub';
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\Transformers';
    }
}
