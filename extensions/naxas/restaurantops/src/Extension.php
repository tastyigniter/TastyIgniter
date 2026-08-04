<?php

declare(strict_types=1);

namespace Naxas\RestaurantOps;

use App\Services\LocationContext;
use Igniter\Cart\Models\Menu;
use Igniter\Cart\Models\OrderMenu;
use Igniter\System\Classes\BaseExtension;
use Naxas\RestaurantOps\Console\InstallCommand;
use Naxas\RestaurantOps\Console\SyncRolesCommand;
use Naxas\RestaurantOps\Console\UpgradeCommand;
use Naxas\RestaurantOps\Console\VerifyInstallationCommand;
use Naxas\RestaurantOps\Console\VerifyMenuIntegrationCommand;
use Naxas\RestaurantOps\Console\VerifyPosCommand;
use Naxas\RestaurantOps\Console\VerifyShiftsCommand;
use Naxas\RestaurantOps\Contracts\AuditLogger;
use Naxas\RestaurantOps\Contracts\LocationContextContract;
use Naxas\RestaurantOps\Http\Middleware\RequiresOperationalPermission;
use Naxas\RestaurantOps\Http\Middleware\RequiresTransactionalLocation;
use Naxas\RestaurantOps\Integrations\ActivityLogAdapter;
use Naxas\RestaurantOps\Listeners\PersistEnhancedOrderSnapshots;
use Naxas\RestaurantOps\MenuConfiguration\Contracts\KitchenRoutingResolver;
use Naxas\RestaurantOps\MenuConfiguration\DefaultKitchenRoutingResolver;
use Naxas\RestaurantOps\MenuIntegration\Contracts\OfficialCartAdapter;
use Naxas\RestaurantOps\MenuIntegration\TastyIgniterCartAdapter;
use Naxas\RestaurantOps\Models\ItemVariant;
use Naxas\RestaurantOps\Models\MenuItemMetadata;
use Naxas\RestaurantOps\Models\OrderItemSnapshot;
use Naxas\RestaurantOps\Pos\Contracts\PosOrderServiceContract;
use Naxas\RestaurantOps\Pos\PosOrderService;
use Naxas\RestaurantOps\Shifts\CashierShiftContext;
use Naxas\RestaurantOps\Shifts\Contracts\PaymentSummaryProvider;
use Naxas\RestaurantOps\Shifts\Contracts\ShiftClosingWarningProvider;
use Naxas\RestaurantOps\Shifts\Contracts\ShiftContextContract;
use Naxas\RestaurantOps\Shifts\OfficialPaymentSummaryProvider;
use Naxas\RestaurantOps\Shifts\PosClosingWarningProvider;
use Naxas\RestaurantOps\Support\PermissionDefinitions;
use Override;

class Extension extends BaseExtension
{
    protected $listen = [
        'igniter.checkout.afterSaveOrder' => [PersistEnhancedOrderSnapshots::class],
    ];

    #[Override]
    public function boot(): void
    {
        Menu::extend(function (Menu $model): void {
            $model->relation['hasMany']['restaurant_ops_variants'] = [ItemVariant::class, 'foreignKey' => 'menu_id'];
            $model->relation['hasOne']['restaurant_ops_metadata'] = [MenuItemMetadata::class, 'foreignKey' => 'menu_id'];
        });
        OrderMenu::extend(function (OrderMenu $model): void {
            $model->relation['hasOne']['restaurant_ops_snapshot'] = [OrderItemSnapshot::class, 'foreignKey' => 'order_menu_id'];
        });
    }

    #[Override]
    public function register(): void
    {
        parent::register();

        $this->app->scoped(LocationContextContract::class, fn ($app): LocationContextContract => $app->make(LocationContext::class));
        $this->app->singleton(AuditLogger::class, ActivityLogAdapter::class);
        $this->app->singleton(KitchenRoutingResolver::class, DefaultKitchenRoutingResolver::class);
        $this->app->scoped(OfficialCartAdapter::class, TastyIgniterCartAdapter::class);
        $this->app->scoped(PaymentSummaryProvider::class, OfficialPaymentSummaryProvider::class);
        $this->app->scoped(ShiftClosingWarningProvider::class, PosClosingWarningProvider::class);
        $this->app->scoped(ShiftContextContract::class, CashierShiftContext::class);
        $this->app->scoped(PosOrderServiceContract::class, PosOrderService::class);
        $this->registerConsoleCommand('restaurant-ops.sync-roles', SyncRolesCommand::class);
        $this->registerConsoleCommand('restaurant-ops.install', InstallCommand::class);
        $this->registerConsoleCommand('restaurant-ops.upgrade', UpgradeCommand::class);
        $this->registerConsoleCommand('restaurant-ops.verify-installation', VerifyInstallationCommand::class);
        $this->registerConsoleCommand('restaurant-ops.verify-menu-integration', VerifyMenuIntegrationCommand::class);
        $this->registerConsoleCommand('restaurant-ops.verify-shifts', VerifyShiftsCommand::class);
        $this->registerConsoleCommand('restaurant-ops.verify-pos', VerifyPosCommand::class);
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
                'title' => lang('Naxas.RestaurantOps::default.navigation.operations'),
                'href' => route('naxas.restaurantops.overview'), 'permission' => 'Restaurant.Operations.Access',
                'child' => [
                    'restaurant-ops-overview' => ['priority' => 10, 'class' => 'restaurant-ops-overview', 'title' => lang('Naxas.RestaurantOps::default.navigation.overview'), 'href' => route('naxas.restaurantops.overview'), 'permission' => 'Restaurant.Operations.Access'],
                    'restaurant-ops-pos' => ['priority' => 41, 'class' => 'restaurant-ops-pos', 'title' => lang('Naxas.RestaurantOps::default.navigation.pos'), 'href' => route('naxas.restaurantops.pos'), 'permission' => 'Restaurant.POS.Access'],
                    'restaurant-ops-pos-active' => ['priority' => 42, 'class' => 'restaurant-ops-pos-active', 'title' => lang('Naxas.RestaurantOps::default.navigation.active_orders'), 'href' => route('naxas.restaurantops.orders.active'), 'permission' => 'Restaurant.POS.Access'],
                    'restaurant-ops-pos-held' => ['priority' => 43, 'class' => 'restaurant-ops-pos-held', 'title' => lang('Naxas.RestaurantOps::default.navigation.held_orders'), 'href' => route('naxas.restaurantops.orders.held'), 'permission' => 'Restaurant.POS.Order.Recall'],
                    'restaurant-ops-waiter' => ['priority' => 50, 'class' => 'restaurant-ops-waiter', 'title' => lang('Naxas.RestaurantOps::default.navigation.waiter'), 'href' => route('naxas.restaurantops.waiter'), 'permission' => 'Restaurant.Waiter.Access'],
                    'restaurant-ops-kitchen' => ['priority' => 60, 'class' => 'restaurant-ops-kitchen', 'title' => lang('Naxas.RestaurantOps::default.navigation.kitchen'), 'href' => route('naxas.restaurantops.kitchen'), 'permission' => 'Restaurant.Kitchen.Access'],
                    'restaurant-ops-menu-config' => ['priority' => 70, 'class' => 'restaurant-ops-menu-config', 'title' => lang('Naxas.RestaurantOps::default.navigation.menu_operations_settings'), 'href' => route('naxas.restaurantops.menu-operations.index'), 'permission' => 'Restaurant.MenuConfig.View'],
                    'restaurant-ops-shifts' => ['priority' => 80, 'class' => 'restaurant-ops-shifts', 'title' => lang('Naxas.RestaurantOps::default.navigation.shifts'), 'href' => route('naxas.restaurantops.shifts.index'), 'permission' => 'Restaurant.Shifts.Access'],
                    'restaurant-ops-active-shift' => ['priority' => 81, 'class' => 'restaurant-ops-active-shift', 'title' => lang('Naxas.RestaurantOps::default.navigation.active_shift'), 'href' => route('naxas.restaurantops.shifts.mine'), 'permission' => 'Restaurant.Shifts.ViewOwn'],
                    'restaurant-ops-shift-review' => ['priority' => 82, 'class' => 'restaurant-ops-shift-review', 'title' => lang('Naxas.RestaurantOps::default.navigation.shift_review'), 'href' => route('naxas.restaurantops.shifts.branch-review'), 'permission' => 'Restaurant.Shifts.ViewBranch'],
                ],
            ],
        ];
    }
}
