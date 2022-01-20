<?php

namespace System\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use System\Classes\ExtensionManager;
use System\Classes\UpdateManager;

class ExtensionRefresh extends Command
{
    use \Illuminate\Console\ConfirmableTrait;

    /**
     * The console command name.
     * @var string
     */
    protected $name = 'extension:refresh';

    /**
     * The console command description.
     * @var string
     */
    protected $description = 'Rollback and re-migrate an existing extension.';

    /**
     * Execute the console command.
     * @return void
     */
    public function handle()
    {
        if (!$this->confirmToProceed()) {
            return;
        }

        $extensionName = $this->argument('name');
        $extensionManager = ExtensionManager::instance();

        $extensionName = $extensionManager->getIdentifier(strtolower($extensionName));
        if (!$extensionManager->hasExtension($extensionName)) {
            throw new \InvalidArgumentException(sprintf('Extension "%s" not found.', $extensionName));
        }

        $manager = UpdateManager::instance();
        $manager->setLogsOutput($this->output);

        if ($step = (int)$this->option('step')) {
            $this->output->writeln(sprintf('<info>Rolling back extension %s...</info>', $extensionName));
            $manager->rollbackExtension($extensionName, [
                'pretend' => $this->option('pretend'),
                'step' => $step,
            ]);
        }
        else {
            $this->output->writeln(sprintf('<info>Purging extension %s...</info>', $extensionName));
            $manager->purgeExtension($extensionName);

            $this->output->writeln(sprintf('<info>Migrating extension %s...</info>', $extensionName));
            $manager->migrateExtension($extensionName);
        }
    }

    /**
     * Get the console command arguments.
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the extension. Eg: IgniterLab.Demo'],
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['pretend', null, InputOption::VALUE_NONE, 'Dump the SQL queries that would be run'],
            ['step', null, InputOption::VALUE_OPTIONAL, 'The number of migrations to be reverted'],
        ];
    }
}
