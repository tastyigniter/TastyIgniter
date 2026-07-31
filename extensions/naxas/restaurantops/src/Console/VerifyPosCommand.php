<?php

declare(strict_types=1);

namespace Naxas\RestaurantOps\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Throwable;

final class VerifyPosCommand extends Command
{
    protected $signature = 'restaurant-ops:verify-pos {--check-environment} {--seed-scenario} {--run-smoke} {--cleanup}';

    protected $description = 'Safely verify the RestaurantOps POS foundation';

    public function handle(): int
    {
        if (! $this->option('check-environment') && ! $this->option('seed-scenario') && ! $this->option('run-smoke') && ! $this->option('cleanup')) {
            $this->error('Choose at least one verification option.');

            return self::INVALID;
        }
        if (($this->option('seed-scenario') || $this->option('cleanup')) && app()->isProduction()) {
            $this->error('Fixture operations are refused in production.');

            return self::FAILURE;
        }
        try {
            $tables = ['naxas_restaurant_ops_pos_orders', 'naxas_restaurant_ops_pos_order_items', 'naxas_restaurant_ops_pos_order_events', 'naxas_restaurant_ops_pos_approval_requests', 'naxas_restaurant_ops_pos_idempotency_keys'];
            $this->info('Driver: '.DB::connection()->getDriverName());
            foreach ($tables as $table) {
                if (! Schema::hasTable($table)) {
                    $this->error($table.': missing');

                    return self::FAILURE;
                } else {
                    $this->info($table.': present');
                }
            }
            $this->info('POS schema smoke check passed. No order, payment, receipt, KOT, inventory, or cash data was changed.');
            if ($this->option('seed-scenario') || $this->option('cleanup')) {
                $this->warn('Fixture mutation is intentionally delegated to the documented disposable local test provider.');
            }

            return self::SUCCESS;
        } catch (Throwable $e) {
            $this->error('POS environment check failed: '.$e->getMessage());

            return self::FAILURE;
        }
    }
}
