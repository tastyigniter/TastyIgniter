<?php

namespace App\Providers;

use App\Services\LocationContext;
use Igniter\User\Classes\PermissionManager;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->scoped(LocationContext::class);

        $this->callAfterResolving(PermissionManager::class, function (PermissionManager $manager): void {
            $manager->registerCallback(function (PermissionManager $manager): void {
                $manager->registerPermissions('Restaurant', [
                    'Restaurant.LocationContext.Access' => ['label' => 'Access assigned locations', 'group' => 'Location operations'],
                    'Restaurant.LocationContext.Switch' => ['label' => 'Switch active location', 'group' => 'Location operations'],
                    'Restaurant.LocationContext.ViewAll' => ['label' => 'Use all-locations reporting mode', 'group' => 'Location operations'],
                    'Restaurant.LocationContext.Manage' => ['label' => 'Manage location operations', 'group' => 'Location operations'],
                ]);
            });
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
