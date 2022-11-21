<?php

namespace System\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use System\Classes\ComposerManager;
use System\Classes\UpdateManager;

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
        $forceUpdate = $this->option('force');

        // update system
        $updateManager = UpdateManager::instance()->setLogsOutput($this->output);
        $composerManager = ComposerManager::instance()->setLogsOutput($this->output);
        $this->output->writeln('<info>Updating TastyIgniter...</info>');

        $updates = $updateManager->requestUpdateList($forceUpdate);
        $itemsToUpdate = array_get($updates, 'items');

        if (!$itemsToUpdate) {
            $this->output->writeln('<info>No new updates found</info>');

            return;
        }

        $updatesCollection = collect($itemsToUpdate)->groupBy('type');

        $coreUpdate = optional($updatesCollection->pull('core'))->first();
        $coreVersion = array_get($coreUpdate, 'version');

        $this->output->writeln('<info>Updating application dependencies...</info>');
        $composerManager->require(['composer/composer']);

        $composerManager->requireCore($coreVersion);

        $packages = $updatesCollection->flatten(1)->map(function ($addon) {
            $addonName = array_get($addon, 'package');
            $addonVersion = array_get($addon, 'version');

            return $addonName.':'.$addonVersion;
        })->all();

        $composerManager->require($packages);

        // Run migrations
        $this->call('igniter:up');
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
