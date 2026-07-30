<?php

declare(strict_types=1);

namespace Igniter\Flame\Scaffold;

use Igniter\Flame\Support\Facades\File;
use Igniter\Flame\Support\Facades\Igniter;
use Igniter\Flame\Support\StringParser;
use Illuminate\Console\Command;
use Illuminate\Console\ConfirmableTrait;
use ReflectionClass;

abstract class GeneratorCommand extends Command
{
    use ConfirmableTrait;

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type;

    /**
     * A mapping of stub to generated file.
     *
     * @var array
     */
    protected $stubs = [];

    /**
     * An array of variables to use in stubs.
     *
     * @var array
     */
    protected $vars = [];

    protected $destinationPath;

    /**
     * Prepare variables for stubs.
     *
     * return @array
     */
    abstract protected function prepareVars();

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        if (!$this->confirmToProceed()) {
            return;
        }

        if ($this->prepareVars() === false) {
            return;
        }

        $this->buildStubs();

        $this->info($this->type.' created successfully.');
    }

    public function buildStubs(): void
    {
        foreach ($this->stubs as $stub => $class) {
            $this->buildStub($stub, $class);
        }
    }

    public function buildStub(string $stubName, string $className)
    {
        $stubFile = $this->getStubPath($stubName);
        $destinationFile = $this->parseString($this->getDestinationPath($className));
        $stubContent = File::get($stubFile);

        // Make sure this file does not already exist
        if (File::exists($destinationFile) && !$this->option('force')) {
            $this->error($this->type.' already exists! '.$destinationFile);

            return false;
        }

        $this->makeDirectory($destinationFile);

        File::put($destinationFile, $this->parseString($stubContent));

        return null;
    }

    protected function getExtensionInput()
    {
        $code = $this->argument('extension');

        if (count($array = explode('.', $code)) !== 2) {
            return null;
        }

        return $array;
    }

    /**
     * Build the directory for the class if necessary.
     *
     * @param string $path
     *
     * @return void
     */
    protected function makeDirectory($path)
    {
        if (!File::isDirectory(dirname($path))) {
            File::makeDirectory(dirname($path), 0777, true, true);
        }
    }

    protected function getStubPath(string $stubName)
    {
        $className = static::class;
        $class = new ReflectionClass($className);

        return dirname($class->getFileName()).'/stubs/'.$stubName;
    }

    protected function getDestinationPath(string $className)
    {
        $code = $this->argument('extension');
        $destinationPath = str_replace('.', '/', strtolower($code));

        return Igniter::extensionsPath().'/'.$destinationPath.'/'.$className;
    }

    protected function parseString(string $stubContent)
    {
        return (new StringParser('{{', '}}'))->parse($stubContent, $this->vars);
    }
}
