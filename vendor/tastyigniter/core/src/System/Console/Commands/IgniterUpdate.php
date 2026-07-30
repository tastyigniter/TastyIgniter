<?php

declare(strict_types=1);

namespace Igniter\System\Console\Commands;

use Igniter\System\Classes\PackageInfo;
use Igniter\System\Classes\UpdateManager;
use Igniter\System\Notifications\SystemUpdateNotification;
use Illuminate\Console\Command;
use Illuminate\Console\ConfirmableTrait;
use Illuminate\Support\Collection;
use Override;
use Symfony\Component\Console\Input\InputOption;
use Throwable;

/**
 * Console command to perform a system update.
 * This updates TastyIgniter and all extensions, database and files. It uses the
 * TastyIgniter gateway to receive the files via a package manager, then saves
 * the latest version number to the system.
 */
class IgniterUpdate extends Command
{
    use ConfirmableTrait;

    /**
     * The console command name.
     */
    protected $name = 'igniter:update';

    /**
     * The console command description.
     */
    protected $description = 'Updates TastyIgniter and all extensions, database and files.';

    protected UpdateManager $updateManager;

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $forceUpdate = (bool)$this->option('force');

        $updateManager = resolve(UpdateManager::class)->setLogsOutput($this->output);
        $this->output->writeln('<info>Checking for updates...</info>');

        $updates = $updateManager->requestUpdateList($forceUpdate);
        $updatesCount = array_get($updates, 'count', 0);
        $this->output->writeln(sprintf('<info>%s updates found</info>', $updatesCount));
        SystemUpdateNotification::make(array_only($updates, 'count'))->broadcast();

        /** @var Collection|null $itemsToUpdate */
        $itemsToUpdate = array_get($updates, 'items');
        if (!$updatesCount || $this->option('check') || !$this->confirmToProceed()) {
            return;
        }

        try {
            $whitelistedAddons = $this->option('addons');
            $whitelistCore = $this->option('core');
            $itemsToUpdate = $itemsToUpdate->filter(
                fn(PackageInfo $packageInfo): bool => ($whitelistCore && $packageInfo->isCore())
                    || ($whitelistedAddons && in_array($packageInfo->code, $whitelistedAddons))
                    || (!$whitelistedAddons && !$whitelistCore),
            );

            if ($itemsToUpdate->count()) {
                $this->output->writeln(sprintf(
                    '<info>Updating system addons: %s</info>',
                    $itemsToUpdate->map(fn(PackageInfo $packageInfo) => sprintf('%s:%s', $packageInfo->package, $packageInfo->version))->implode(', '),
                ));

                $installedPackages = $updateManager->install($itemsToUpdate->all(), $this->output);
                $updateManager->completeInstall($installedPackages);

                $this->output->writeln('<info>Updating system addons complete</info>');
            }

            // Run migrations
            $updateManager->migrate();
        } catch (Throwable $throwable) {
            $this->output->writeln($throwable->getMessage());
        }
    }

    /**
     * Get the console command options.
     */
    #[Override]
    protected function getOptions(): array
    {
        return [
            ['force', null, InputOption::VALUE_NONE, 'Force updates.'],
            ['check', null, InputOption::VALUE_NONE, 'Run update checks only.'],
            ['core', null, InputOption::VALUE_NONE, 'Update core application files only.'],
            ['addons', null, InputOption::VALUE_OPTIONAL | InputOption::VALUE_IS_ARRAY, 'Update specified extensions & themes files only.'],
        ];
    }
}
