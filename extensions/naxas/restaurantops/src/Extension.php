<?php

declare(strict_types=1);

namespace Naxas\RestaurantOps;

use App\Services\LocationContext;
use Igniter\System\Classes\BaseExtension;
use Naxas\RestaurantOps\Console\SyncRolesCommand;
use Naxas\RestaurantOps\Contracts\AuditLogger;
use Naxas\RestaurantOps\Contracts\LocationContextContract;
use Naxas\RestaurantOps\Http\Middleware\RequiresOperationalPermission;
use Naxas\RestaurantOps\Http\Middleware\RequiresTransactionalLocation;
use Naxas\RestaurantOps\Integrations\ActivityLogAdapter;
use Naxas\RestaurantOps\Support\PermissionDefinitions;
use Override;

class Extension extends BaseExtension
{
    #[Override]
    public function register(): void
    {
        parent::register();

        $this->app->scoped(LocationContextContract::class, fn ($app): LocationContextContract => $app->make(LocationContext::class));
        $this->app->singleton(AuditLogger::class, ActivityLogAdapter::class);
        $this->registerConsoleCommand('restaurant-ops.sync-roles', SyncRolesCommand::class);
        $this->app['router']->aliasMiddleware('restaurant.ops.permission', RequiresOperationalPermission::class);
        $this->app['router']->aliasMiddleware('restaurant.ops.transactional', RequiresTransactionalLocation::class);
    }

    #[Override]
    public function registerPermissions(): array
    {
        return PermissionDefinitions::all();
    }

    #[Override]
    public function registerNavigation(): array
    {
        return [
            'restaurant-operations' => [
                'priority' => 450, 'class' => 'restaurant-operations', 'icon' => 'fa fa-store',
                'title' => 'naxas.restaurantops::default.navigation.operations',
                'href' => admin_url('restaurant-ops'), 'permission' => 'Restaurant.Operations.Access',
                'child' => [
                    'restaurant-ops-overview' => ['title' => 'naxas.restaurantops::default.navigation.overview', 'href' => admin_url('restaurant-ops'), 'permission' => 'Restaurant.Operations.Access'],
                    'restaurant-ops-head-office' => ['title' => 'naxas.restaurantops::default.navigation.head_office', 'href' => admin_url('restaurant-ops/head-office'), 'permission' => 'Restaurant.Operations.HeadOfficeDashboard'],
                    'restaurant-ops-branch' => ['title' => 'naxas.restaurantops::default.navigation.branch', 'href' => admin_url('restaurant-ops/branch'), 'permission' => 'Restaurant.Operations.BranchDashboard'],
                    'restaurant-ops-cashier' => ['title' => 'naxas.restaurantops::default.navigation.cashier', 'href' => admin_url('restaurant-ops/cashier'), 'permission' => 'Restaurant.POS.Access'],
                    'restaurant-ops-waiter' => ['title' => 'naxas.restaurantops::default.navigation.waiter', 'href' => admin_url('restaurant-ops/waiter'), 'permission' => 'Restaurant.Waiter.Access'],
                    'restaurant-ops-kitchen' => ['title' => 'naxas.restaurantops::default.navigation.kitchen', 'href' => admin_url('restaurant-ops/kitchen'), 'permission' => 'Restaurant.Kitchen.Access'],
                ],
            ],
        ];
    }
}
