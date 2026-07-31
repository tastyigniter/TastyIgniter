<?php

declare(strict_types=1);

namespace Tests\Unit;

use Naxas\RestaurantOps\MenuConfiguration\AttachmentResolver;
use Naxas\RestaurantOps\MenuConfiguration\CartCompatibilityMapper;
use Naxas\RestaurantOps\MenuConfiguration\DefaultKitchenRoutingResolver;
use Naxas\RestaurantOps\MenuConfiguration\Exceptions\InvalidConfiguration;
use Naxas\RestaurantOps\MenuConfiguration\PricingResolver;
use Naxas\RestaurantOps\MenuConfiguration\SelectionValidator;
use Naxas\RestaurantOps\MenuConfiguration\Support\Context;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

final class MenuConfigurationEngineTest extends TestCase
{
    public function test_pricing_is_decimal_safe_deterministic_and_ignores_unrecognized_client_price(): void
    {
        $input = ['menu_id' => 1, 'base_price' => '10.1250', 'special_price' => '9.9999', 'variant_price' => '2.0001', 'modifiers' => [['id' => 2, 'quantity' => 3, 'free_quantity' => 1, 'unit_price' => '0.3333']], 'combo_choices' => [['quantity' => 2, 'surcharge' => '1.0000']], 'client_price' => '0.01'];
        $first = (new PricingResolver)->resolve($input);
        $second = (new PricingResolver)->resolve($input);
        self::assertSame('14.6666', $first['subtotal']);
        self::assertSame($first, $second);
        self::assertSame(64, strlen($first['configuration_hash']));
    }

    public function test_absolute_variant_and_context_override_are_server_calculated(): void
    {
        $price = (new PricingResolver)->resolve(['base_price' => '10', 'variant_price' => '12.50', 'variant_price_mode' => 'absolute', 'context_price_override' => '11.00']);
        self::assertSame('11.0000', $price['subtotal']);
        self::assertSame('-1.5000', $price['location_service_adjustment']);
    }

    #[DataProvider('invalidGroups')]
    public function test_invalid_group_rules_are_rejected(array $group, array $selections): void
    {
        $this->expectException(InvalidConfiguration::class);
        (new SelectionValidator)->validateGroup($group, $selections);
    }

    public static function invalidGroups(): array
    {
        return [
            'min over max' => [['is_active' => true, 'min_selections' => 2, 'max_selections' => 1], []],
            'single max over one' => [['is_active' => true, 'selection_type' => 'single', 'max_selections' => 2], []],
            'required incomplete' => [['is_active' => true, 'is_required' => true, 'max_selections' => 1], []],
            'inactive modifier' => [['is_active' => true, 'max_selections' => 2], [['attached' => true, 'is_active' => false]]],
            'quantity exceeded' => [['is_active' => true, 'max_selections' => 9], [['attached' => true, 'is_active' => true, 'allow_quantity' => true, 'quantity' => 3, 'max_quantity' => 2]]],
        ];
    }

    public function test_valid_required_multi_select_and_quantities(): void
    {
        (new SelectionValidator)->validateGroup(['is_active' => true, 'is_required' => true, 'selection_type' => 'multiple', 'min_selections' => 2, 'max_selections' => 4], [['attached' => true, 'is_active' => true, 'allow_quantity' => true, 'quantity' => 2, 'max_quantity' => 3]]);
        self::addToAssertionCount(1);
    }

    public function test_condition_and_combo_cycles_are_rejected(): void
    {
        $this->expectException(InvalidConfiguration::class);
        (new SelectionValidator)->validateConditionGraph([[1, 2], [2, 3], [3, 1]]);
    }

    public function test_attachment_precedence_skips_null_inheritance_values(): void
    {
        $resolved = (new AttachmentResolver)->resolve(['required' => false, 'min' => 0, 'max' => 5], ['required' => true, 'min' => 1], ['required' => null, 'max' => 2]);
        self::assertSame(['required' => true, 'min' => 1, 'max' => 2], $resolved);
    }

    public function test_cart_mapper_preserves_legacy_and_distinguishes_enhanced_identity(): void
    {
        $mapper = new CartCompatibilityMapper;
        self::assertSame(['mode' => 'legacy', 'options' => [5]], $mapper->mapLegacy(['menu_options' => [5]]));
        $a = $mapper->mapEnhanced(['menu_options' => [5], 'restaurant_ops' => ['configuration_hash' => 'ok', 'variant_id' => 1, 'modifiers' => [['id' => 2, 'quantity' => 1]]]], 'ok');
        $b = $mapper->mapEnhanced(['restaurant_ops' => ['configuration_hash' => 'ok', 'variant_id' => 2, 'modifiers' => [['id' => 2, 'quantity' => 1]]]], 'ok');
        self::assertNotSame($a['identity_hash'], $b['identity_hash']);
    }

    public function test_stale_cart_configuration_is_rejected(): void
    {
        $this->expectException(InvalidConfiguration::class);
        (new CartCompatibilityMapper)->mapEnhanced(['restaurant_ops' => ['configuration_hash' => 'old']], 'new');
    }

    public function test_context_requires_location_and_maps_takeaway(): void
    {
        self::assertSame('collection', (new Context(1, 'takeaway', 'pos'))->officialServiceType());
    }

    public function test_kitchen_resolution_uses_variant_modifier_and_item_precedence_without_dispatch(): void
    {
        $routing = (new DefaultKitchenRoutingResolver)->resolve(['item' => ['name' => 'Burger', 'kitchen_station_id' => 1], 'variant' => ['kitchen_name' => 'L BURGER', 'kitchen_station_id' => 2], 'modifiers' => [['name' => 'Cheese', 'kitchen_name' => 'X CHZ', 'kitchen_station_id' => 3]]]);
        self::assertSame('L BURGER', $routing['name']);
        self::assertSame(2, $routing['station_id']);
        self::assertSame(3, $routing['modifiers'][0]['station_id']);
        self::assertArrayNotHasKey('ticket', $routing);
    }
}
