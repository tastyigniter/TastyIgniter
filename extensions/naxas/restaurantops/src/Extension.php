<?php

declare(strict_types=1);

namespace Naxas\RestaurantOps;

use App\Services\LocationContext;
use Igniter\Cart\Models\Menu;
use Igniter\Cart\Models\OrderMenu;
use Igniter\System\Classes\BaseExtension;
use Naxas\RestaurantOps\Console\SyncRolesCommand;
use Naxas\RestaurantOps\Console\VerifyMenuIntegrationCommand;
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
use Naxas\RestaurantOps\Shifts\CashierShiftContext;
use Naxas\RestaurantOps\Shifts\Contracts\PaymentSummaryProvider;
use Naxas\RestaurantOps\Shifts\Contracts\ShiftClosingWarningProvider;
use Naxas\RestaurantOps\Shifts\Contracts\ShiftContextContract;
use Naxas\RestaurantOps\Shifts\NullClosingWarningProvider;
use Naxas\RestaurantOps\Shifts\OfficialPaymentSummaryProvider;
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
        $this->app->scoped(ShiftClosingWarningProvider::class, NullClosingWarningProvider::class);
        $this->app->scoped(ShiftContextContract::class, CashierShiftContext::class);
        $this->registerConsoleCommand('restaurant-ops.sync-roles', SyncRolesCommand::class);
        $this->registerConsoleCommand('restaurant-ops.verify-menu-integration', VerifyMenuIntegrationCommand::class);
        $this->registerConsoleCommand('restaurant-ops.verify-shifts', VerifyShiftsCommand::class);
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
                'href' => admin_url('restaurant-ops'), 'permission' => 'Restaurant.Operations.Access',
                'child' => [
                    'restaurant-ops-overview' => ['priority' => 10, 'class' => 'restaurant-ops-overview', 'title' => lang('Naxas.RestaurantOps::default.navigation.overview'), 'href' => admin_url('restaurant-ops'), 'permission' => 'Restaurant.Operations.Access'],
                    'restaurant-ops-head-office' => ['priority' => 20, 'class' => 'restaurant-ops-head-office', 'title' => lang('Naxas.RestaurantOps::default.navigation.head_office'), 'href' => admin_url('restaurant-ops/head-office'), 'permission' => 'Restaurant.Operations.HeadOfficeDashboard'],
                    'restaurant-ops-branch' => ['priority' => 30, 'class' => 'restaurant-ops-branch', 'title' => lang('Naxas.RestaurantOps::default.navigation.branch'), 'href' => admin_url('restaurant-ops/branch'), 'permission' => 'Restaurant.Operations.BranchDashboard'],
                    'restaurant-ops-cashier' => ['priority' => 40, 'class' => 'restaurant-ops-cashier', 'title' => lang('Naxas.RestaurantOps::default.navigation.cashier'), 'href' => admin_url('restaurant-ops/cashier'), 'permission' => 'Restaurant.POS.Access'],
                    'restaurant-ops-waiter' => ['priority' => 50, 'class' => 'restaurant-ops-waiter', 'title' => lang('Naxas.RestaurantOps::default.navigation.waiter'), 'href' => admin_url('restaurant-ops/waiter'), 'permission' => 'Restaurant.Waiter.Access'],
                    'restaurant-ops-kitchen' => ['priority' => 60, 'class' => 'restaurant-ops-kitchen', 'title' => lang('Naxas.RestaurantOps::default.navigation.kitchen'), 'href' => admin_url('restaurant-ops/kitchen'), 'permission' => 'Restaurant.Kitchen.Access'],
                    'restaurant-ops-menu-config' => ['priority' => 70, 'class' => 'restaurant-ops-menu-config', 'title' => lang('Naxas.RestaurantOps::default.navigation.menu_configuration'), 'href' => admin_url('restaurant-ops/menu-configuration'), 'permission' => 'Restaurant.MenuConfig.Access'],
                    'restaurant-ops-shifts' => ['priority' => 80, 'class' => 'restaurant-ops-shifts', 'title' => lang('Naxas.RestaurantOps::default.navigation.shifts'), 'href' => admin_url('restaurant-ops/shifts'), 'permission' => 'Restaurant.Shifts.Access'],
                    'restaurant-ops-active-shift' => ['priority' => 81, 'class' => 'restaurant-ops-active-shift', 'title' => lang('Naxas.RestaurantOps::default.navigation.active_shift'), 'href' => admin_url('restaurant-ops/shifts/open'), 'permission' => 'Restaurant.Shifts.ViewOwn'],
                    'restaurant-ops-shift-review' => ['priority' => 82, 'class' => 'restaurant-ops-shift-review', 'title' => lang('Naxas.RestaurantOps::default.navigation.shift_review'), 'href' => admin_url('restaurant-ops/shifts?status=submitted'), 'permission' => 'Restaurant.Shifts.ViewBranch'],
                ],
            ],
        ];
    }
}
