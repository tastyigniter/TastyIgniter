<?php

namespace System\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use System\Classes\ExtensionManager;
use System\Classes\UpdateManager;
use System\Models\Extensions_model;

class ExtensionRemove extends Command
{
    use \Illuminate\Console\ConfirmableTrait;

    /**
     * The console command name.
     * @var string
     */
    protected $name = 'extension:remove';

    /**
     * The console command description.
     * @var string
     */
    protected $description = 'Removes an existing extension.';

    /**
     * Execute the console command.
     * @return void
     */
    public function handle()
    {
        $forceDelete = $this->option('force');
        $extensionName = $this->argument('name');
        $extensionManager = ExtensionManager::instance();

        $extensionName = $extensionManager->getIdentifier(strtolower($extensionName));
        if (!$extensionManager->hasExtension($extensionName)) {
            return $this->error(sprintf('Unable to find a registered extension called "%s"', $extensionName));
        }

        if (!$forceDelete AND !$this->confirmToProceed(sprintf(
                'This will DELETE extension "%s" from the filesystem and database.',
                $extensionName
            ))) {
            return;
        }

        Extensions_model::deleteExtension($extensionName);
        $this->output->writeln(sprintf('<info>Deleted extension: %s</info>', $extensionName));

        foreach (UpdateManager::instance()->getLogs() as $note) {
            $this->output->writeln($note);
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
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['force', null, InputOption::VALUE_NONE, 'Force remove.'],
        ];
    }

    /**
     * Get the default confirmation callback.
     * @return \Closure
     */
    protected function getDefaultConfirmCallback()
    {
        return function () {
            return TRUE;
        };
    }
}