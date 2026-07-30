<?php

declare(strict_types=1);

namespace Igniter\Flame\Database;

use Igniter\Flame\Database\Attach\Manipulator;
use Igniter\Flame\Database\Attach\Media;
use Igniter\Flame\Database\Attach\MediaAdder;
use Igniter\Flame\Database\Attach\Observers\MediaObserver;
use Igniter\Flame\Database\Connections\MySqlConnection;
use Igniter\Flame\Database\Connectors\ConnectionFactory;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Database\DatabaseManager;
use Illuminate\Database\DatabaseServiceProvider as BaseDatabaseServiceProvider;
use Illuminate\Database\DatabaseTransactionsManager;
use Illuminate\Database\Eloquent\Relations\Relation;
use Override;

class DatabaseServiceProvider extends BaseDatabaseServiceProvider
{
    /**
     * Register the service provider.
     */
    #[Override]
    public function register(): void
    {
        Model::clearExtendedClasses();

        parent::register();

        $this->app->singleton(Manipulator::class);
        $this->app->singleton(MediaAdder::class);
        $this->app->singleton(MemoryCache::class);

        $this->app->booted(function() {
            $connection = $this->app['db']->connection();
            $connectionName = $connection->getName();
            $existingValue = $this->app['config']->get('database.connections.'.$connectionName.'.strict');
            if ($connection instanceof MySqlConnection && $existingValue) {
                $this->app['config']->set('database.connections.'.$connectionName.'.strict', false);
                $this->app['db']->purge($connectionName);
                $this->app['db']->reconnect($connectionName);
            }
        });
    }

    #[Override]
    public function boot(): void
    {
        parent::boot();

        Media::observe(MediaObserver::class);

        Relation::morphMap([
            'media' => Media::class,
        ]);
    }

    /**
     * Register the primary database bindings.
     *
     * @return void
     */
    #[Override]
    protected function registerConnectionServices()
    {
        // The connection factory is used to create the actual connection instances on
        // the database. We will inject the factory into the manager so that it may
        // make the connections while they are actually needed and not of before.
        $this->app->singleton('db.factory', fn($app): ConnectionFactory => new ConnectionFactory($app));

        // The database manager is used to resolve various connections, since multiple
        // connections might be managed. It also implements the connection resolver
        // interface which may be used by other components requiring connections.
        $this->app->singleton('db', fn(Application $app): DatabaseManager => new DatabaseManager($app, $app['db.factory']));

        $this->app->bind('db.connection', fn(Application $app) => $app['db']->connection());

        $this->app->singleton('db.transactions', fn($app): DatabaseTransactionsManager => new DatabaseTransactionsManager);
    }
}
