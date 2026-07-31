<?php

declare(strict_types=1);

namespace Tests\Feature;

use Igniter\Cart\Models\Category;
use Igniter\Cart\Models\Menu;
use Igniter\Cart\Models\MenuItemOption;
use Igniter\Cart\Models\MenuItemOptionValue;
use Igniter\Cart\Models\MenuOption;
use Igniter\Cart\Models\MenuOptionValue;
use Naxas\RestaurantOps\Http\Controllers\MenuConfiguration\MenuConfigurations;
use Naxas\RestaurantOps\MenuConfiguration\Contracts\KitchenRoutingResolver;
use Naxas\RestaurantOps\Models\ItemVariant;
use Naxas\RestaurantOps\Support\PermissionDefinitions;
use Tests\TestCase;

final class MenuConfigurationCompatibilityTest extends TestCase
{
    public function test_official_menu_option_seams_and_extension_models_remain_distinct(): void
    {
        self::assertSame('menus', (new Menu)->getTable());
        self::assertSame('categories', (new Category)->getTable());
        self::assertSame('menu_options', (new MenuOption)->getTable());
        self::assertSame('menu_option_values', (new MenuOptionValue)->getTable());
        self::assertSame('menu_item_options', (new MenuItemOption)->getTable());
        self::assertSame('menu_item_option_values', (new MenuItemOptionValue)->getTable());
        self::assertSame('naxas_restaurant_ops_item_variants', (new ItemVariant)->getTable());
        self::assertInstanceOf(KitchenRoutingResolver::class, app(KitchenRoutingResolver::class));
    }

    public function test_menu_configuration_permissions_are_unique_and_safe_defaults_are_preserved(): void
    {
        $permissions = PermissionDefinitions::all();
        self::assertCount(count(array_unique(array_keys($permissions))), $permissions);
        foreach (['Access', 'View', 'Manage', 'Variants.Manage', 'Modifiers.Manage', 'Combos.Manage', 'Pricing.Manage', 'Availability.Manage', 'KitchenRouting.Manage', 'LocationOverrides.Manage'] as $permission) {
            self::assertArrayHasKey('Restaurant.MenuConfig.'.$permission, $permissions);
        }
    }

    public function test_routes_use_named_class_actions_and_configurable_admin_prefix(): void
    {
        $route = app('router')->getRoutes()->getByName('naxas.restaurantops.menu-configuration.variants.store');
        self::assertNotNull($route);
        self::assertStringStartsWith(trim(parse_url(admin_url(''), PHP_URL_PATH), '/').'/', trim($route->uri(), '/'));
        self::assertSame(
            MenuConfigurations::class.'@storeVariant',
            $route->getActionName(),
        );
        self::assertContains('restaurant.ops.permission:Restaurant.MenuConfig.Variants.Manage', $route->gatherMiddleware());
    }
}
