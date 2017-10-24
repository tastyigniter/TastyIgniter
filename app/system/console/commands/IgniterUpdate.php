<?php namespace System\Console\Commands;

use Str;
use Config;
use Illuminate\Console\Command;
use System\Classes\UpdateManager;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

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
        $this->output->writeln('<info>Updating TastyIgniter...</info>');
        $manager = UpdateManager::instance()->resetLogs();
        $forceUpdate = $this->option('force');

        $disableCore = $this->option('core') ? TRUE : FALSE;
        $disableAddons = $this->option('addons') ? TRUE : FALSE;

        $updateList = $manager->requestUpdateList($forceUpdate);
        $updatesCount = (int)array_get($updateList, 'count', 0);
        $updateItems = array_get($updateList, 'items', []);

        if ($updatesCount == 0) {
            $this->output->writeln('<info>No new updates found</info>');

            return;
        }
        else {
            $this->output->writeln(sprintf(
                '<info>Found %s new %s!</info>',
                $updatesCount,
                Str::plural('update', $updatesCount)
            ));
        }

        // Download updates
        foreach ($updateItems as $updateItem) {
            $itemCode = array_get($updateItem, 'code');
            $itemName = array_get($updateItem, 'name');
            $itemHash = array_get($updateItem, 'hash');
            $itemType = array_get($updateItem, 'type');

            if ($disableCore AND $itemType == 'core')
                continue;

            $this->output->writeln(sprintf(
                '<info>Downloading %s: %s</info>', $itemType, $itemName
            ));

            $manager->downloadFile($itemCode, $itemHash);
        }

        // Extract updates
        foreach ($updateItems as $updateItem) {
            $itemCode = array_get($updateItem, 'code');
            $itemName = array_get($updateItem, 'name');
            $itemHash = array_get($updateItem, 'hash');
            $itemType = array_get($updateItem, 'type');

            if ($itemType == 'core') {
                $this->output->writeln('<info>Unpacking application files</info>');
                $manager->extractCore($itemCode);
            }
            else {
                $this->output->writeln(sprintf(
                    '<info>Unpacking %s: %s</info>', $itemType, $itemName
                ));

                $manager->extractFile($itemCode, $itemHash);
            }
        }

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
