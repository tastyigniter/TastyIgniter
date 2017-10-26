<?php namespace System\Console\Commands;

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
        $manager = UpdateManager::instance()->resetLogs()->update();

        $this->output->writeln('<info>Migrating application and extensions...</info>');

        foreach ($manager->getLogs() as $note) {
            $this->output->writeln($note);
        }
    }
}
