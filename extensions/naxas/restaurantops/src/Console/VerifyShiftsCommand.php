<?php

declare(strict_types=1);

namespace Naxas\RestaurantOps\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Throwable;

final class VerifyShiftsCommand extends Command
{
    protected $signature = 'restaurant-ops:verify-shifts
        {--check-environment : Check runtime, schema and shift prerequisites}
        {--seed-scenario : Reserved for explicit disposable fixture providers}
        {--run-smoke : Run a non-destructive schema smoke check}
        {--cleanup : Reserved for marked disposable fixtures}';

    protected $description = 'Safely verify the RestaurantOps cashier shift foundation';

    public function handle(): int
    {
        if (! $this->option('check-environment') && ! $this->option('seed-scenario') && ! $this->option('run-smoke') && ! $this->option('cleanup')) {
            $this->error('Choose at least one verification option.');

            return self::INVALID;
        }
        if (($this->option('seed-scenario') || $this->option('cleanup')) && app()->isProduction()) {
            $this->error('Fixture creation and cleanup are refused in production.');

            return self::FAILURE;
        }
        try {
            $tables = ['naxas_restaurant_ops_cashier_shifts', 'naxas_restaurant_ops_cash_movements', 'naxas_restaurant_ops_shift_submissions', 'naxas_restaurant_ops_shift_denominations'];
            if ($this->option('check-environment') || $this->option('run-smoke')) {
                $this->components->info('Driver: '.DB::connection()->getDriverName());
                $missing = [];
                foreach ($tables as $table) {
                    $present = Schema::hasTable($table);
                    $this->components->{$present ? 'info' : 'error'}($table.': '.($present ? 'present' : 'missing'));
                    if (! $present) {
                        $missing[] = $table;
                    }
                }
                if ($missing) {
                    return self::FAILURE;
                }
                $this->components->info('Shift schema smoke check passed. No data was changed.');
            }
            if ($this->option('seed-scenario') || $this->option('cleanup')) {
                $this->warn('No production fixture provider is registered. Use the dedicated test fixture provider documented in the runbook.');
            }
        } catch (Throwable $exception) {
            $this->error('Shift environment check failed: '.$exception->getMessage());

            return self::FAILURE;
        }

        return self::SUCCESS;
    }
}
