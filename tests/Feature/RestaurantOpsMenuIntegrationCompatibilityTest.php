<?php

declare(strict_types=1);

namespace Tests\Feature;

use Igniter\Cart\Classes\CartManager;
use Igniter\Cart\Classes\OrderManager;
use Igniter\Cart\Models\Menu;
use Igniter\Cart\Models\MenuOption;
use Igniter\Cart\Models\MenuOptionValue;
use Igniter\Cart\Models\OrderMenu;
use Illuminate\Support\Facades\Event;
use Naxas\RestaurantOps\Listeners\PersistEnhancedOrderSnapshots;
use Naxas\RestaurantOps\MenuIntegration\Contracts\OfficialCartAdapter;
use Tests\TestCase;

final class RestaurantOpsMenuIntegrationCompatibilityTest extends TestCase
{
    public function test_versioned_routes_are_public_web_class_actions_and_legacy_routes_remain_registered(): void
    {
        $routes = app('router')->getRoutes();
        $quote = $routes->getByName('naxas.restaurantops.v1.cart.quote');
        $add = $routes->getByName('naxas.restaurantops.v1.cart.items.store');

        self::assertSame('restaurant-ops/v1/cart/quote', $quote->uri());
        self::assertSame(['POST'], $quote->methods());
        self::assertContains('web', $quote->gatherMiddleware());
        self::assertSame('restaurant-ops/v1/cart/items', $add->uri());
        self::assertNotNull($routes->getByName('igniter.theme.cart'));
        self::assertNotNull($routes->getByName('igniter.theme.checkout.checkout'));
    }

    public function test_official_public_integration_seams_exist(): void
    {
        self::assertTrue(method_exists(CartManager::class, 'addCartItem'));
        self::assertTrue(method_exists(CartManager::class, 'getCart'));
        self::assertTrue(method_exists(OrderManager::class, 'saveOrder'));
        self::assertArrayHasKey('menu', (new OrderMenu)->relation['belongsTo']);
        self::assertTrue(class_exists(Menu::class));
        self::assertTrue(class_exists(MenuOption::class));
        self::assertTrue(class_exists(MenuOptionValue::class));
        self::assertTrue(method_exists(PersistEnhancedOrderSnapshots::class, 'handle'));
        self::assertInstanceOf(OfficialCartAdapter::class, app(OfficialCartAdapter::class));
        self::assertNotEmpty(Event::getListeners('igniter.checkout.afterSaveOrder'));
    }

    public function test_historical_snapshot_route_is_permission_protected(): void
    {
        $route = app('router')->getRoutes()->getByName('naxas.restaurantops.order-item-snapshots.show');

        self::assertNotNull($route);
        self::assertContains('restaurant.ops.permission:Restaurant.Operations.Access', $route->gatherMiddleware());
    }
}
