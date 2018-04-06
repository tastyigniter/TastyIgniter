<?php namespace System\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;

/**
 * Console command to perform a system update.
 * This updates TastyIgniter and all extensions, database and files. It uses the
 * TastyIgniter gateway to receive the files via a package manager, then saves
 * the latest version number to the system.
 */
class IgniterUpdate extends Command
{
    /**
     * The console command name.
     */
    protected $name = 'igniter:update';

    /**
     * The console command description.
     */
    protected $description = 'Updates TastyIgniter and all extensions, database and files.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // update system

        // Run migrations
        $this->call('igniter:up');
    }

    /**
     * Get the console command arguments.
     */
    protected function getArguments()
    {
        return [];
    }

    /**
     * Get the console command options.
     */
    protected function getOptions()
    {
        return [
            ['force', null, InputOption::VALUE_NONE, 'Force updates.'],
            ['core', null, InputOption::VALUE_NONE, 'Update core application files only.'],
            ['addons', null, InputOption::VALUE_NONE, 'Update both extensions & themes files.'],
        ];
    }
}
