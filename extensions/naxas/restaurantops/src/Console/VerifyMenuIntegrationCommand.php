<?php

declare(strict_types=1);

namespace Naxas\RestaurantOps\Console;

use Igniter\Local\Models\Location;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Naxas\RestaurantOps\Listeners\PersistEnhancedOrderSnapshots;
use Naxas\RestaurantOps\MenuIntegration\IntegrationScenario;
use Naxas\RestaurantOps\MenuIntegration\MenuSelectionResolver;
use Naxas\RestaurantOps\Models\SnapshotFailure;
use Throwable;

final class VerifyMenuIntegrationCommand extends Command
{
    protected $signature = 'restaurant-ops:verify-menu-integration
        {--check-environment : Check runtime, schema and extension prerequisites}
        {--seed-scenario : Create the documented disposable BBQ pizza scenario}
        {--run-smoke : Resolve an authoritative quote for the scenario}
        {--cleanup : Delete only marked integration scenario records}
        {--reconcile-snapshots : Retry durable failed snapshot writes}';

    protected $description = 'Safely verify the RestaurantOps enhanced menu integration';

    public function handle(IntegrationScenario $scenario, MenuSelectionResolver $resolver, PersistEnhancedOrderSnapshots $listener): int
    {
        if (! $this->option('check-environment') && ! $this->option('seed-scenario') && ! $this->option('run-smoke') && ! $this->option('cleanup') && ! $this->option('reconcile-snapshots')) {
            $this->error('Choose at least one verification option.');

            return self::INVALID;
        }
        if (($this->option('seed-scenario') || $this->option('cleanup')) && app()->isProduction()) {
            $this->error('Fixture creation and cleanup are refused in production.');

            return self::FAILURE;
        }
        try {
            if ($this->option('check-environment')) {
                $this->components->info('Driver: '.DB::connection()->getDriverName());
                $this->components->info('Database: '.DB::connection()->getDatabaseName());
                $this->components->info('Server: '.DB::selectOne('select version() as version')->version);
                foreach (['naxas_restaurant_ops_menu_item_metadata', 'naxas_restaurant_ops_order_item_snapshots', 'naxas_restaurant_ops_snapshot_failures', 'naxas_restaurant_ops_cart_idempotency'] as $table) {
                    $this->components->{Schema::hasTable($table) ? 'info' : 'error'}($table.': '.(Schema::hasTable($table) ? 'present' : 'missing'));
                }
            }
            $ids = null;
            if ($this->option('seed-scenario')) {
                $ids = $scenario->seed();
                $this->line(json_encode($ids, JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR));
            }
            if ($this->option('run-smoke')) {
                $ids ??= $scenario->existing();
                if (! $ids) {
                    $this->error('The marked scenario does not exist; seed it explicitly in a non-production environment.');

                    return self::FAILURE;
                }
                app('location')->setCurrent(Location::query()->findOrFail($ids['location_id']));
                $quote = $resolver->resolve($scenario->request($ids));
                $this->line(json_encode(array_diff_key($quote, ['_official_menu_options' => true]), JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR));
            }
            if ($this->option('reconcile-snapshots')) {
                SnapshotFailure::query()->orderBy('last_attempt_at')->each(fn (SnapshotFailure $failure) => $listener->retryFailure($failure));
            }
            if ($this->option('cleanup')) {
                $scenario->cleanup();
                $this->components->info('Marked integration scenario removed.');
            }
        } catch (Throwable $exception) {
            $this->error($exception->getMessage());

            return self::FAILURE;
        }

        return self::SUCCESS;
    }
}
