<?php

namespace App\Providers;

use App\Services\LocationContext;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('access-location', fn ($user, $locationId): bool => app(LocationContext::class)->forUser($user)->canAccess($locationId));
        Gate::define('switch-location', fn ($user, $locationId): bool => app(LocationContext::class)->forUser($user)->canAccess($locationId));
        Gate::define('view-all-locations', fn ($user): bool => $user->hasPermission('Restaurant.LocationContext.ViewAll'));
        Gate::define('manage-location-operations', fn ($user): bool => $user->hasPermission('Restaurant.LocationContext.Manage'));
    }
}
