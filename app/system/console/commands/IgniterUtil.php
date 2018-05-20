<?php namespace System\Console\Commands;

use Assets;
use File;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;

class IgniterUtil extends Command
{
    /**
     * The console command name.
     * @var string
     */
    protected $name = 'igniter:util';

    /**
     * The console command description.
     * @var string
     */
    protected $description = 'TastyIgniter Utility commands.';

    /**
     * Execute the console command.
     * @return void
     */
    public function handle()
    {
        $command = implode(' ', (array)$this->argument('name'));
        $method = 'util'.studly_case($command);

        if (!method_exists($this, $method)) {
            $this->error(sprintf('Utility command "%s" does not exist!', $command));

            return;
        }

        $this->$method();
    }

    /**
     * Get the console command arguments.
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['name', InputArgument::IS_ARRAY, 'The utility command to perform.'],
        ];
    }

    protected function utilCompileJs()
    {
        $this->utilCompileAssets('js');
    }

    protected function utilCompileLess()
    {
        $this->utilCompileAssets('less');
    }

    protected function utilCompileScss()
    {
        $this->utilCompileAssets('scss');
    }

    protected function utilCompileAssets($type = null)
    {
        $this->comment('Compiling registered asset bundles...');

        config('system.enableAssetMinify', FALSE);
        $bundles = Assets::getBundles($type);

        if (!$bundles) {
            $this->comment('Nothing to compile!');

            return;
        }

        foreach ($bundles as $destination => $assets) {
            $destination = File::symbolizePath($destination);
            $publicDestination = File::localToPublic(realpath(dirname($destination))).'/'.basename($destination);

            Assets::combineToFile($assets, $destination);
            $this->comment(implode(', ', array_map('basename', $assets)));
            $this->comment(sprintf(' -> %s', $publicDestination));
        }
    }
}
