<?php

namespace System\Console\Commands;

use Illuminate\Console\Command;
use System\Classes\UpdateManager;

class IgniterUp extends Command
{
    /**
     * The console command name.
     * @var string
     */
    protected $name = 'igniter:up';

    /**
     * The console command description.
     * @var string
     */
    protected $description = 'Builds database tables for TastyIgniter and all extensions.';

    /**
     * Execute the console command.
     * @return void
     */
    public function handle()
    {
        $this->output->writeln('<info>Migrating application and extensions...</info>');

        $manager = UpdateManager::instance();
        $manager->setLogsOutput($this->output);
        $manager->update();
    }
}
