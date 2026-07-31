<?php

declare(strict_types=1);

namespace Naxas\RestaurantOps\MenuIntegration;

use Igniter\Cart\Models\Menu;
use Igniter\Cart\Models\MenuItemOption;
use Igniter\Cart\Models\MenuItemOptionValue;
use Igniter\Cart\Models\MenuOption;
use Igniter\Cart\Models\MenuOptionValue;
use Igniter\Local\Models\Location;
use Illuminate\Support\Facades\DB;
use Naxas\RestaurantOps\Models\AvailabilityOverride;
use Naxas\RestaurantOps\Models\ItemVariant;
use Naxas\RestaurantOps\Models\MenuItemMetadata;
use Naxas\RestaurantOps\Models\MenuModifierGroup;
use Naxas\RestaurantOps\Models\ModifierGroup;
use Naxas\RestaurantOps\Models\ModifierMetadata;

final class IntegrationScenario
{
    public const string MARKER = 'restaurantops-integration-test';

    public function seed(): array
    {
        return DB::transaction(function (): array {
            $location = Location::query()->where('permalink_slug', self::MARKER)->first()
                ?? Location::query()->create(['location_name' => 'Integration Test Branch', 'location_status' => true, 'location_email' => 'integration@example.test', 'location_telephone' => '0000000000', 'permalink_slug' => self::MARKER]);
            $menu = Menu::query()->firstOrCreate(['menu_name' => 'BBQ Chicken Pizza', 'menu_description' => self::MARKER], ['menu_price' => '500.0000', 'minimum_qty' => 1, 'menu_status' => true]);
            $metadata = MenuItemMetadata::query()->updateOrCreate(['menu_id' => $menu->getKey()], ['kitchen_name' => 'BBQ Chicken Pizza', 'version' => 1]);
            $variants = collect([
                ['code' => self::MARKER.'-8', 'name' => '8 inch', 'price_value' => '-50.0000', 'is_default' => false],
                ['code' => self::MARKER.'-10', 'name' => '10 inch', 'price_value' => '0.0000', 'is_default' => true],
                ['code' => self::MARKER.'-12', 'name' => '12 inch', 'price_value' => '100.0000', 'is_default' => false],
            ])->map(fn (array $data) => ItemVariant::query()->updateOrCreate(['menu_id' => $menu->getKey(), 'code' => $data['code']], $data + ['price_mode' => 'adjustment', 'is_active' => true]));

            [$crustGroup, $crustModifiers] = $this->group($menu, 'Choose Crust', 'single', true, 1, 1, [
                ['Thin', '0.0000', false], ['Regular', '0.0000', false], ['Stuffed', '100.0000', false],
            ]);
            [$toppingGroup, $toppingModifiers] = $this->group($menu, 'Extra Toppings', 'multiple', false, 0, 5, [
                ['Mushroom', '40.0000', true], ['Olive', '50.0000', true], ['Extra Cheese', '80.0000', true],
            ]);
            foreach ([$crustGroup, $toppingGroup] as $group) {
                MenuModifierGroup::query()->updateOrCreate(['menu_id' => $menu->getKey(), 'variant_id' => null, 'modifier_group_id' => $group->getKey()], ['is_active' => true]);
            }
            $ten = $variants->firstWhere('name', '10 inch');
            AvailabilityOverride::query()->updateOrCreate(['location_id' => $location->getKey(), 'menu_id' => $menu->getKey(), 'variant_id' => $ten->getKey(), 'modifier_group_id' => null, 'modifier_id' => null, 'service_type' => 'delivery', 'channel' => 'storefront'], ['price_override' => '600.0000', 'is_available' => true, 'is_visible' => true, 'is_sellable' => true]);
            AvailabilityOverride::query()->updateOrCreate(['location_id' => $location->getKey(), 'menu_id' => $menu->getKey(), 'variant_id' => $ten->getKey(), 'modifier_group_id' => $toppingGroup->getKey(), 'modifier_id' => $toppingModifiers['Olive']->getKey(), 'service_type' => 'collection', 'channel' => 'storefront'], ['is_available' => false]);

            return [
                'location_id' => $location->getKey(), 'menu_id' => $menu->getKey(), 'variant_id' => $ten->getKey(),
                'crust_group_id' => $crustGroup->getKey(), 'stuffed_modifier_id' => $crustModifiers['Stuffed']->getKey(),
                'topping_group_id' => $toppingGroup->getKey(), 'cheese_modifier_id' => $toppingModifiers['Extra Cheese']->getKey(),
                'configuration_version' => $metadata->version,
            ];
        });
    }

    public function request(array $ids): array
    {
        return ['contract_version' => '1.0', 'menu_id' => $ids['menu_id'], 'location_id' => $ids['location_id'], 'service_type' => 'delivery', 'channel' => 'storefront', 'quantity' => 1, 'variant_id' => $ids['variant_id'], 'modifier_selections' => [['group_id' => $ids['crust_group_id'], 'modifiers' => [['modifier_id' => $ids['stuffed_modifier_id'], 'quantity' => 1]]], ['group_id' => $ids['topping_group_id'], 'modifiers' => [['modifier_id' => $ids['cheese_modifier_id'], 'quantity' => 2]]]], 'combo_selections' => [], 'item_note' => 'Integration verification'];
    }

    public function existing(): ?array
    {
        $location = Location::query()->where('permalink_slug', self::MARKER)->first();
        $menu = Menu::query()->where('menu_name', 'BBQ Chicken Pizza')->where('menu_description', self::MARKER)->first();
        $variant = $menu ? ItemVariant::query()->where('menu_id', $menu->getKey())->where('code', self::MARKER.'-10')->first() : null;
        $crust = ModifierGroup::query()->where('code', self::MARKER.'-choose-crust')->first();
        $toppings = ModifierGroup::query()->where('code', self::MARKER.'-extra-toppings')->first();
        $stuffed = $crust ? ModifierMetadata::query()->where('code', self::MARKER.'-choose-crust-stuffed')->first() : null;
        $cheese = $toppings ? ModifierMetadata::query()->where('code', self::MARKER.'-extra-toppings-extra-cheese')->first() : null;
        if (! $location || ! $menu || ! $variant || ! $crust || ! $toppings || ! $stuffed || ! $cheese) {
            return null;
        }

        return ['location_id' => $location->getKey(), 'menu_id' => $menu->getKey(), 'variant_id' => $variant->getKey(), 'crust_group_id' => $crust->getKey(), 'stuffed_modifier_id' => $stuffed->getKey(), 'topping_group_id' => $toppings->getKey(), 'cheese_modifier_id' => $cheese->getKey()];
    }

    public function cleanup(): void
    {
        DB::transaction(function (): void {
            $menu = Menu::query()->where('menu_name', 'BBQ Chicken Pizza')->where('menu_description', self::MARKER)->first();
            if ($menu) {
                AvailabilityOverride::query()->where('menu_id', $menu->getKey())->delete();
                MenuModifierGroup::query()->where('menu_id', $menu->getKey())->delete();
                ItemVariant::query()->where('menu_id', $menu->getKey())->where('code', 'like', self::MARKER.'%')->forceDelete();
                MenuItemMetadata::query()->where('menu_id', $menu->getKey())->delete();
                foreach (MenuItemOption::query()->where('menu_id', $menu->getKey())->get() as $attachment) {
                    MenuItemOptionValue::query()->where('menu_option_id', $attachment->getKey())->delete();
                    $attachment->delete();
                }
                $menu->delete();
            }
            foreach (ModifierGroup::query()->where('code', 'like', self::MARKER.'%')->get() as $group) {
                $optionId = $group->option_id;
                ModifierMetadata::query()->whereIn('option_value_id', MenuOptionValue::query()->where('option_id', $optionId)->pluck('option_value_id'))->forceDelete();
                $group->forceDelete();
                MenuOptionValue::query()->where('option_id', $optionId)->delete();
                MenuOption::query()->whereKey($optionId)->delete();
            }
            Location::query()->where('permalink_slug', self::MARKER)->delete();
        });
    }

    private function group(Menu $menu, string $name, string $selectionType, bool $required, int $min, int $max, array $values): array
    {
        $code = self::MARKER.'-'.str($name)->slug();
        $displayType = $selectionType === 'single' ? 'radio' : 'quantity';
        $existingGroup = ModifierGroup::query()->where('code', $code)->first();
        $option = $existingGroup ? MenuOption::query()->findOrFail($existingGroup->option_id) : MenuOption::query()->create(['option_name' => $name, 'display_type' => $displayType]);
        $attachment = MenuItemOption::query()->updateOrCreate(['menu_id' => $menu->getKey(), 'option_id' => $option->getKey()], ['is_required' => $required, 'min_selected' => $min, 'max_selected' => $max, 'free_quantity' => 0]);
        $group = ModifierGroup::query()->updateOrCreate(['code' => $code], ['option_id' => $option->getKey(), 'name' => $name, 'selection_type' => $selectionType, 'is_required' => $required, 'min_selections' => $min, 'max_selections' => $max, 'allow_quantity' => $selectionType !== 'single', 'max_quantity_per_modifier' => 5, 'is_active' => true]);
        $modifiers = [];
        foreach ($values as [$valueName, $price, $quantity]) {
            $value = MenuOptionValue::query()->firstOrCreate(['option_id' => $option->getKey(), 'name' => $valueName], ['price' => $price]);
            MenuItemOptionValue::query()->updateOrCreate(['menu_option_id' => $attachment->getKey(), 'option_value_id' => $value->getKey()], ['override_price' => $price]);
            $modifiers[$valueName] = ModifierMetadata::query()->updateOrCreate(['option_value_id' => $value->getKey()], ['code' => $code.'-'.str($valueName)->slug(), 'price_adjustment' => $price, 'allow_quantity' => $quantity, 'min_quantity' => 0, 'max_quantity' => $quantity ? 5 : 1, 'is_active' => true]);
        }

        return [$group, $modifiers];
    }
}
