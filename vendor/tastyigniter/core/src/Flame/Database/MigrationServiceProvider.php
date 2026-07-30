<?php

declare(strict_types=1);

namespace Igniter\Flame\Database;

use Igniter\Flame\Database\Migrations\DatabaseMigrationRepository;
use Igniter\Flame\Database\Migrations\Migrator;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Database\MigrationServiceProvider as BaseServiceProvider;
use Override;

class MigrationServiceProvider extends BaseServiceProvider
{
    #[Override]
    public function register(): void
    {
        $this->app->register(BaseServiceProvider::class);

        parent::register();
    }

    /**
     * Override the Laravel repository service.
     *
     * @return void
     */
    #[Override]
    protected function registerRepository()
    {
        $this->app->singleton('migration.repository', function(Application $app): DatabaseMigrationRepository {
            $migrations = $app['config']['database.migrations'];
            $table = is_array($migrations) ? ($migrations['table'] ?? null) : $migrations;

            return new DatabaseMigrationRepository($app['db'], $table);
        });

        $this->app->alias('migration.repository', DatabaseMigrationRepository::class);
    }

    /**
     * Override the Laravel migrator singleton
     *
     * @return void
     */
    #[Override]
    protected function registerMigrator()
    {
        $this->app->singleton('migrator', function(Application $app): Migrator {
            $repository = $app['migration.repository'];

            return new Migrator($repository, $app['db'], $app['files'], $app['events']);
        });

        $this->app->alias('migrator', Migrator::class);
    }
}
