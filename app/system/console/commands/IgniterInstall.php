<?php

namespace System\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;

/**
 * Console command to install TastyIgniter.
 * This sets up TastyIgniter for the first time. It will prompt the user for several
 * configuration items, including application URL and database config, and then
 * perform a database migration.
 */
class IgniterInstall extends Command
{
    /**
     * The console command name.
     */
    protected $name = 'igniter:install';

    /**
     * The console command description.
     */
    protected $description = 'Set up TastyIgniter for the first time.';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
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
            ['extensions', null, InputOption::VALUE_NONE, 'Update extension files only.'],
        ];
    }
}
