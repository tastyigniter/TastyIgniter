<?php

declare(strict_types=1);

namespace Naxas\RestaurantOps\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Naxas\RestaurantOps\Support\MigrationSchema;
use Throwable;

class InstallCommand extends Command
{
    protected $signature = 'restaurant-ops:install {--force}';

    protected $description = 'Preflight and install RestaurantOps through the native TastyIgniter lifecycle';

    public function handle(): int
    {
        try {
            $this->components->info('Connection: '.DB::connection()->getName());
            $this->components->info('Database: '.DB::selectOne('select database() as name')->name);
            $this->components->info('Engine/version: mysql '.DB::selectOne('select version() as version')->version);
            $this->components->info('Prefix: '.DB::connection()->getTablePrefix());
            MigrationSchema::assertPreflight();
        } catch (Throwable $exception) {
            $this->components->error('Preflight failed before mutation: '.$exception->getMessage());

            return self::FAILURE;
        }

        return $this->call('igniter:up', ['--force' => (bool) $this->option('force')]);
    }
}
