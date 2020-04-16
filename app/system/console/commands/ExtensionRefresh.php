<?php

namespace System\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;
use System\Classes\ExtensionManager;
use System\Classes\UpdateManager;

class ExtensionRefresh extends Command
{
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
        $extensionName = $this->argument('name');
        $extensionManager = ExtensionManager::instance();

        $extensionName = $extensionManager->getIdentifier(strtolower($extensionName));
        if (!$extensionManager->hasExtension($extensionName)) {
            throw new \InvalidArgumentException(sprintf('Extension "%s" not found.', $extensionName));
        }

        $manager = UpdateManager::instance();
        $manager->setLogsOutput($this->output);

        $this->output->writeln(sprintf('<info>Removing extension %s...</info>', $extensionName));
        $extensionManager->uninstallExtension($extensionName, true);

        $this->output->writeln(sprintf('<info>Reinstalling extension %s...</info>', $extensionName));
        $extensionManager->installExtension($extensionName);
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
}