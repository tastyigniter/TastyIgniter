<?php namespace System\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
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
        $updateManager = UpdateManager::instance()->resetLogs();
        $this->output->writeln('<info>Updating TastyIgniter...</info>');

        $updates = $updateManager->requestUpdateList($forceUpdate);
        $itemsToUpdate = array_get($updates, 'items');

        if (!$itemsToUpdate) {
            $this->output->writeln('<info>No new updates found</info>');

            return;
        }

        $updatesCollection = collect($itemsToUpdate)->groupBy('type');

        $coreUpdate = $updatesCollection->pull('core')->first();
        $coreCode = array_get($coreUpdate, 'code');
        $coreVersion = array_get($coreUpdate, 'version');
        $coreHash = array_get($coreUpdate, 'hash');

        $addonUpdates = $updatesCollection->flatten(1);

        if ($coreCode AND $coreHash) {
            $this->output->writeln('<info>Downloading application files</info>');
            $updateManager->downloadFile($coreCode, $coreHash, [
                'name' => $coreCode,
                'type' => 'core',
                'ver'  => $coreVersion,
            ]);
        }

        $addonUpdates->each(function ($addon) use ($updateManager) {
            $addonCode = array_get($addon, 'code');
            $addonName = array_get($addon, 'name');
            $addonType = array_get($addon, 'type');
            $addonVersion = array_get($addon, 'version');
            $addonHash = array_get($addon, 'hash');

            $this->output->writeln(sprintf('<info>Downloading %s files</info>', $addonName));

            $updateManager->downloadFile($addonCode, $addonHash, [
                'name' => $addonCode,
                'type' => $addonType,
                'ver'  => $addonVersion,
            ]);
        });

        if ($coreCode AND $coreHash) {
            $this->output->writeln('<info>Extracting application files</info>');
            $updateManager->extractCore($coreCode);
            $updateManager->setCoreVersion($coreVersion, $coreHash);
        }

        $addonUpdates->each(function ($addon) use ($updateManager) {
            $addonCode = array_get($addon, 'code');
            $addonName = array_get($addon, 'name');
            $addonType = array_get($addon, 'type');

            $this->output->writeln(sprintf('<info>Extracting %s files</info>', $addonName));

            $updateManager->extractFile($addonCode, $addonType.'s/');
        });

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
