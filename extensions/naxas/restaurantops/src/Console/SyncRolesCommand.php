<?php

declare(strict_types=1);

namespace Naxas\RestaurantOps\Console;

use Illuminate\Console\Command;
use Naxas\RestaurantOps\Services\RoleSynchronizer;

final class SyncRolesCommand extends Command
{
    protected $signature = 'restaurant-ops:sync-roles {--dry-run : Preview without writing} {--create-missing : Create missing custom roles and add their missing catalog grants} {--add-missing-permissions : Add only missing catalog grants} {--group= : Limit to a profile or stable role code}';

    protected $description = 'Preview or non-destructively synchronize standard Restaurant Operations roles';

    public function handle(RoleSynchronizer $synchronizer): int
    {
        $writeRequested = (bool) $this->option('create-missing') || (bool) $this->option('add-missing-permissions');
        $dryRun = (bool) $this->option('dry-run') || ! $writeRequested;
        $result = $synchronizer->sync($dryRun, (bool) $this->option('create-missing'), (bool) $this->option('add-missing-permissions'), $this->option('group'));

        $this->info($dryRun ? 'Restaurant Operations role sync preview' : 'Restaurant Operations role sync');
        foreach ($result as $label => $items) {
            $this->line(ucfirst($label).': '.(count($items) ? implode(', ', $items) : 'none'));
        }

        if ($result['missing permissions']) {
            $this->error('Role synchronization was safely blocked. Register the listed codes through Naxas.RestaurantOps::registerPermissions and clear the application caches before retrying.');
        }

        return $result['missing permissions'] ? self::FAILURE : self::SUCCESS;
    }
}
