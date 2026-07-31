<?php

declare(strict_types=1);

namespace Naxas\RestaurantOps\MenuIntegration;

use Igniter\Cart\Models\Menu;
use Igniter\Cart\Models\MenuItemOptionValue;
use Igniter\Local\Models\Location;
use Naxas\RestaurantOps\MenuConfiguration\AttachmentResolver;
use Naxas\RestaurantOps\MenuConfiguration\AvailabilityResolver;
use Naxas\RestaurantOps\MenuConfiguration\PricingResolver;
use Naxas\RestaurantOps\MenuConfiguration\SelectionValidator;
use Naxas\RestaurantOps\MenuConfiguration\Support\Context;
use Naxas\RestaurantOps\Models\Combo;
use Naxas\RestaurantOps\Models\ComboChoice;
use Naxas\RestaurantOps\Models\ComboGroup;
use Naxas\RestaurantOps\Models\ItemVariant;
use Naxas\RestaurantOps\Models\MenuItemMetadata;
use Naxas\RestaurantOps\Models\MenuModifierGroup;
use Naxas\RestaurantOps\Models\ModifierGroup;
use Naxas\RestaurantOps\Models\ModifierMetadata;

final class MenuSelectionResolver
{
    public function __construct(
        private readonly AvailabilityResolver $availability,
        private readonly SelectionValidator $validator,
        private readonly AttachmentResolver $attachments,
        private readonly PricingResolver $pricing,
    ) {}

    public function resolve(array $input): array
    {
        $context = $this->context($input);
        $location = Location::query()->find($context->locationId);
        if (! $location) {
            throw new IntegrationException('restaurantops_location_forbidden', 'The selected location is not available.', 403);
        }
        if (! $location->location_status) {
            throw new IntegrationException('restaurantops_location_inactive', 'The selected location is inactive.', 422);
        }
        $this->assertCurrentStorefrontLocation($context->locationId);

        $menu = Menu::query()->with(['special', 'locations', 'menu_options.menu_option_values.option_value'])->find((int) $input['menu_id']);
        if (! $menu || ! $menu->menu_status) {
            throw new IntegrationException('restaurantops_menu_not_found', 'The selected menu item is not available.');
        }
        if ($menu->locations->isNotEmpty() && ! $menu->locations->contains('location_id', $context->locationId)) {
            throw new IntegrationException('restaurantops_location_forbidden', 'The menu item is not sold by the selected location.', 403);
        }
        $metadata = MenuItemMetadata::query()->where('menu_id', $menu->getKey())->first();
        if (! $metadata) {
            throw new IntegrationException('restaurantops_enhanced_configuration_required', 'This menu item does not have enhanced configuration.');
        }
        if (! $this->channelVisible($metadata, $context->channel)) {
            throw new IntegrationException('restaurantops_item_unavailable', 'The menu item is hidden in this channel.');
        }

        $variant = $this->variant($menu->getKey(), $input['variant_id'] ?? null, $context);
        $menuAvailability = $this->availability->resolve($menu->getKey(), $context);
        $variantAvailability = $this->availability->resolve($menu->getKey(), $context, ['variant_id' => $variant->getKey()]);
        $this->assertAvailable($menuAvailability, 'restaurantops_item_unavailable');
        $this->assertAvailable($variantAvailability, 'restaurantops_item_unavailable');

        [$modifiers, $officialOptions, $modifierSnapshot, $versions] = $this->modifiers($menu, $variant, $context, (array) ($input['modifier_selections'] ?? []));
        [$comboPricing, $comboSnapshot, $comboVersions] = $this->combos($menu->getKey(), (array) ($input['combo_selections'] ?? []));

        $pricing = $this->pricing->resolve([
            'menu_id' => $menu->getKey(),
            'base_price' => $this->decimal($menu->menu_price),
            'special_price' => $menu->special?->active() ? $this->decimal($menu->getBuyablePrice()) : null,
            'variant_id' => $variant->getKey(),
            'variant_price' => (string) $variant->price_value,
            'variant_price_mode' => $variant->price_mode,
            'modifiers' => $modifiers,
            'combo_choices' => $comboPricing,
            'context_price_override' => $variantAvailability['price_override'] ?? $menuAvailability['price_override'],
            'context' => ['location_id' => $context->locationId, 'service_type' => $context->officialServiceType(), 'channel' => $context->channel],
            'version' => [
                [$metadata->version, $metadata->updated_at?->getTimestamp()],
                [$variant->version, $variant->updated_at?->getTimestamp()],
                $menuAvailability['configuration_versions'], $variantAvailability['configuration_versions'],
                $versions, $comboVersions,
            ],
        ]);

        if (($input['configuration_hash'] ?? null) && ! hash_equals($pricing['configuration_hash'], (string) $input['configuration_hash'])) {
            throw new IntegrationException('restaurantops_configuration_stale', 'Menu configuration changed; request a new quote.', 409);
        }

        $identity = [
            'menu_id' => $menu->getKey(), 'variant_id' => $variant->getKey(),
            'modifiers' => collect($modifierSnapshot)->map(fn (array $group): array => ['group_id' => $group['id'], 'modifiers' => collect($group['modifiers'])->map(fn (array $modifier): array => ['modifier_id' => $modifier['id'], 'quantity' => $modifier['quantity']])->sortBy('modifier_id')->values()->all()])->sortBy('group_id')->values()->all(),
            'combo_selections' => $comboSnapshot, 'location_id' => $context->locationId,
            'service_type' => $context->officialServiceType(), 'channel' => $context->channel,
            'item_note' => (string) ($input['item_note'] ?? ''),
        ];
        $quantity = (int) $input['quantity'];

        return [
            'contract_version' => '1.0', 'configuration_hash' => $pricing['configuration_hash'],
            'menu_id' => $menu->getKey(), 'menu_name' => $menu->menu_name,
            'kitchen_name' => $metadata->kitchen_name ?: $menu->menu_name,
            'variant' => ['id' => $variant->getKey(), 'code' => $variant->code, 'name' => $variant->name, 'kitchen_name' => $variant->kitchen_name ?: $variant->name],
            'modifiers' => $modifierSnapshot, 'combo_selections' => $comboSnapshot,
            'service_type' => $context->officialServiceType(), 'channel' => $context->channel,
            'location_id' => $context->locationId, 'location_name' => $location->location_name,
            'quantity' => $quantity, 'item_note' => (string) ($input['item_note'] ?? ''),
            'canonical_cart_identity' => hash('sha256', json_encode($identity, JSON_THROW_ON_ERROR)),
            'availability' => ['available' => true, 'sellable' => true, 'visible' => true],
            'price_breakdown' => $pricing,
            'authoritative_unit_total' => $pricing['subtotal'],
            'authoritative_line_total' => $this->multiply($pricing['subtotal'], $quantity),
            'warnings' => $context->serviceType === 'takeaway' ? ['takeaway_mapped_to_collection'] : [],
            '_official_menu_options' => $officialOptions,
        ];
    }

    private function context(array $input): Context
    {
        if (($input['location_mode'] ?? null) === 'global' || ($input['location_id'] ?? 0) < 1) {
            throw new IntegrationException('restaurantops_global_mode_not_allowed', 'A concrete location is required.');
        }
        try {
            return new Context((int) $input['location_id'], (string) $input['service_type'], (string) $input['channel']);
        } catch (\Throwable $exception) {
            throw new IntegrationException('restaurantops_context_invalid', $exception->getMessage());
        }
    }

    private function assertCurrentStorefrontLocation(int $locationId): void
    {
        try {
            $currentId = app('location')->getId();
        } catch (\Throwable) {
            $currentId = null;
        }
        if (! $currentId) {
            throw new IntegrationException('restaurantops_location_required', 'Select a storefront location before using enhanced ordering.');
        }
        if ((int) $currentId !== $locationId) {
            throw new IntegrationException('restaurantops_location_forbidden', 'The request location does not match the active storefront location.', 403);
        }
    }

    private function variant(int $menuId, mixed $variantId, Context $context): ItemVariant
    {
        $query = ItemVariant::query()->where('menu_id', $menuId)->where('is_active', true)->whereNull('archived_at');
        $variant = $variantId ? (clone $query)->whereKey((int) $variantId)->first() : (clone $query)->where('is_default', true)->first();
        if (! $variant) {
            throw new IntegrationException('restaurantops_variant_invalid', 'The selected variant does not belong to this menu item.');
        }
        $visible = match ($context->channel) {
            'storefront' => $variant->storefront_visible && $variant->online_visible,
            'pos' => $variant->pos_visible,
            default => true,
        };
        $serviceVisible = (bool) $variant->{$context->officialServiceType().'_visible'};
        if (! $visible || ! $serviceVisible) {
            throw new IntegrationException('restaurantops_selection_hidden', 'The selected variant is hidden in this context.');
        }

        return $variant;
    }

    private function modifiers(Menu $menu, ItemVariant $variant, Context $context, array $submitted): array
    {
        $submitted = collect($submitted)->keyBy(fn (array $group): int => (int) ($group['group_id'] ?? 0));
        $submittedModifierIds = $submitted->flatMap(fn (array $group): array => array_column((array) ($group['modifiers'] ?? []), 'modifier_id'))->map(fn ($id): int => (int) $id)->filter()->unique()->values();
        $modifierModels = ModifierMetadata::query()->whereIn('id', $submittedModifierIds)->whereNull('archived_at')->get()->keyBy('id');
        $officialValueModels = MenuItemOptionValue::query()->whereIn('option_value_id', $modifierModels->pluck('option_value_id'))->whereHas('menu_option', fn ($query) => $query->where('menu_id', $menu->getKey()))->get()->keyBy('option_value_id');
        $attachments = MenuModifierGroup::query()->where('menu_id', $menu->getKey())->where('is_active', true)
            ->where(fn ($query) => $query->whereNull('variant_id')->orWhere('variant_id', $variant->getKey()))->orderBy('display_order')->get()->groupBy('modifier_group_id');
        $pricing = $official = $snapshot = $versions = [];
        foreach ($attachments as $groupId => $candidates) {
            $group = ModifierGroup::query()->whereKey($groupId)->where('is_active', true)->whereNull('archived_at')->first();
            if (! $group) {
                continue;
            }
            $baseAttachment = $candidates->firstWhere('variant_id', null);
            $variantAttachment = $candidates->firstWhere('variant_id', $variant->getKey());
            $rules = $this->attachments->resolve($group->toArray(), $baseAttachment?->toArray(), $variantAttachment?->toArray());
            $rules['is_required'] = $rules['required_override'] ?? $rules['is_required'];
            $rules['min_selections'] = $rules['min_override'] ?? $rules['min_selections'];
            $rules['max_selections'] = $rules['max_override'] ?? $rules['max_selections'];
            $rules['free_quantity'] = $rules['free_quantity_override'] ?? $rules['free_quantity'];
            $rules['visible'] = $this->groupVisible($group, $context);
            $selectedGroup = $submitted->pull((int) $groupId, ['modifiers' => []]);
            $resolvedSelections = [];
            $groupPricing = [];
            $groupSnapshot = ['id' => $group->getKey(), 'code' => $group->code, 'name' => $group->name, 'kitchen_name' => $group->kitchen_name ?: $group->name, 'modifiers' => []];
            $officialValues = [];
            foreach ((array) ($selectedGroup['modifiers'] ?? []) as $selected) {
                $modifier = $modifierModels->get((int) ($selected['modifier_id'] ?? 0));
                $optionValue = $modifier ? $officialValueModels->get($modifier->option_value_id) : null;
                $menuOption = $optionValue ? $menu->menu_options->firstWhere('menu_option_id', $optionValue->menu_option_id) : null;
                if (! $modifier || ! $optionValue || ! $menuOption || (int) $menuOption->option_id !== (int) $group->option_id) {
                    throw new IntegrationException('restaurantops_modifier_invalid', 'A modifier is not attached to the selected group.');
                }
                $availability = $this->availability->resolve($menu->getKey(), $context, ['variant_id' => $variant->getKey(), 'modifier_group_id' => $group->getKey(), 'modifier_id' => $modifier->getKey()]);
                $quantity = (int) ($selected['quantity'] ?? 1);
                $resolved = ['attached' => true, 'is_active' => $modifier->is_active && ! $modifier->is_sold_out, 'available' => $availability['is_available'] && $availability['is_sellable'], 'visible' => $availability['is_visible'] && $this->modifierVisible($modifier, $context), 'quantity' => $quantity, 'allow_quantity' => $modifier->allow_quantity || $group->allow_quantity, 'min_quantity' => $modifier->min_quantity, 'max_quantity' => min($modifier->max_quantity, $group->max_quantity_per_modifier)];
                $resolvedSelections[] = $resolved;
                $price = $availability['price_override'] ?? $modifier->price_adjustment ?? $optionValue->price;
                $groupPricing[] = ['id' => $modifier->getKey(), 'quantity' => $quantity, 'free_quantity' => 0, 'unit_price' => (string) $price];
                $officialValues[$optionValue->getKey()] = ['id' => $optionValue->getKey(), 'qty' => $quantity];
                $groupSnapshot['modifiers'][] = ['id' => $modifier->getKey(), 'code' => $modifier->code, 'name' => $optionValue->name, 'kitchen_name' => $modifier->kitchen_name ?: $optionValue->name, 'quantity' => $quantity, 'unit_price' => (string) $price];
                $versions[] = [$modifier->version, $modifier->updated_at?->getTimestamp(), $availability['configuration_versions']];
            }
            $this->validator->validateGroup($rules, $resolvedSelections);
            $freeRemaining = (int) $rules['free_quantity'];
            foreach ($groupPricing as &$priceLine) {
                $priceLine['free_quantity'] = min($priceLine['quantity'], $freeRemaining);
                $freeRemaining -= $priceLine['free_quantity'];
            }
            unset($priceLine);
            array_push($pricing, ...$groupPricing);
            if ($groupSnapshot['modifiers']) {
                $snapshot[] = $groupSnapshot;
                $menuOption = $menu->menu_options->firstWhere('option_id', $group->option_id);
                if (! $menuOption) {
                    throw new IntegrationException('restaurantops_modifier_group_invalid', 'The modifier group is not backed by an official menu option attachment.');
                }
                $official[$menuOption->getKey()] = ['option_values' => $officialValues];
            }
            $versions[] = [$group->version, $group->updated_at?->getTimestamp()];
        }
        if ($submitted->isNotEmpty()) {
            throw new IntegrationException('restaurantops_modifier_group_invalid', 'A submitted modifier group is not attached to this menu or variant.');
        }

        return [$pricing, $official, $snapshot, $versions];
    }

    private function combos(int $menuId, array $submitted): array
    {
        $combo = Combo::query()->where('menu_id', $menuId)->where('is_active', true)->whereNull('archived_at')->first();
        if (! $combo) {
            if ($submitted) {
                throw new IntegrationException('restaurantops_combo_invalid', 'This menu item is not an active combo.');
            }

            return [[], [], []];
        }
        $submitted = collect($submitted)->keyBy(fn (array $group): int => (int) ($group['group_id'] ?? 0));
        $pricing = $snapshot = $versions = [];
        foreach (ComboGroup::query()->where('combo_id', $combo->getKey())->orderBy('display_order')->get() as $group) {
            $selections = (array) ($submitted->pull($group->getKey(), ['choices' => []])['choices'] ?? []);
            $count = array_sum(array_map(fn (array $choice): int => (int) ($choice['quantity'] ?? 1), $selections));
            if ($count < $group->min_selections || $count > $group->max_selections) {
                throw new IntegrationException('restaurantops_combo_invalid', 'Combo selections do not satisfy the group limits.');
            }
            foreach ($selections as $selection) {
                $choice = ComboChoice::query()->whereKey((int) ($selection['choice_id'] ?? 0))->where('combo_group_id', $group->getKey())->where('is_active', true)->first();
                if (! $choice) {
                    throw new IntegrationException('restaurantops_combo_invalid', 'A combo choice is invalid.');
                }
                $quantity = (int) ($selection['quantity'] ?? 1);
                $pricing[] = ['id' => $choice->getKey(), 'quantity' => $quantity, 'surcharge' => (string) $choice->upgrade_surcharge];
                $snapshot[] = ['group_id' => $group->getKey(), 'group_name' => $group->name, 'choice_id' => $choice->getKey(), 'menu_id' => $choice->menu_id, 'variant_id' => $choice->variant_id, 'quantity' => $quantity, 'surcharge' => (string) $choice->upgrade_surcharge];
            }
            $versions[] = [$group->updated_at?->getTimestamp(), $group->getKey()];
        }
        if ($submitted->isNotEmpty()) {
            throw new IntegrationException('restaurantops_combo_invalid', 'A combo group is invalid.');
        }

        return [$pricing, $snapshot, [$combo->version, $versions]];
    }

    private function assertAvailable(array $availability, string $code): void
    {
        if (! $availability['is_available'] || ! $availability['is_visible'] || ! $availability['is_sellable']) {
            throw new IntegrationException($code, 'The selected item is unavailable in this context.');
        }
    }

    private function channelVisible(object $model, string $channel): bool
    {
        return (bool) ($model->{$channel.'_visible'} ?? true);
    }

    private function groupVisible(ModifierGroup $group, Context $context): bool
    {
        return $this->channelVisible($group, $context->channel) && (bool) $group->{$context->officialServiceType().'_visible'};
    }

    private function modifierVisible(ModifierMetadata $modifier, Context $context): bool
    {
        return $this->channelVisible($modifier, $context->channel);
    }

    private function decimal(float|int|string $value): string
    {
        return number_format((float) $value, 4, '.', '');
    }

    private function multiply(string $amount, int $quantity): string
    {
        [$whole, $fraction] = array_pad(explode('.', $amount, 2), 2, '');
        $minor = (((int) $whole * 10000) + (int) str_pad($fraction, 4, '0')) * $quantity;

        return intdiv($minor, 10000).'.'.str_pad((string) ($minor % 10000), 4, '0', STR_PAD_LEFT);
    }
}
