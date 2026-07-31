<?php

declare(strict_types=1);

namespace Naxas\RestaurantOps\Http\Controllers\MenuConfiguration;

use Igniter\Cart\Models\Menu;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Naxas\RestaurantOps\Contracts\AuditLogger;
use Naxas\RestaurantOps\Models\Combo;
use Naxas\RestaurantOps\Models\ItemVariant;
use Naxas\RestaurantOps\Models\MenuModifierGroup;
use Naxas\RestaurantOps\Models\ModifierGroup;

final class MenuConfigurations
{
    public function __construct(private readonly AuditLogger $audit) {}

    public function catalog(): View
    {
        return view('naxas.restaurantops::menu-configuration-catalog', [
            'menus' => Menu::query()->orderBy('menu_name')->paginate(30),
        ]);
    }

    public function index(Menu $menu): View
    {
        return view('naxas.restaurantops::menu-configuration', ['menu' => $menu, 'variants' => ItemVariant::query()->where('menu_id', $menu->getKey())->orderBy('display_order')->get(), 'groups' => MenuModifierGroup::query()->where('menu_id', $menu->getKey())->orderBy('display_order')->get(), 'sharedGroups' => ModifierGroup::query()->where('is_active', true)->orderBy('display_order')->get(), 'combo' => Combo::query()->where('menu_id', $menu->getKey())->first()]);
    }

    public function storeVariant(Request $request, Menu $menu): JsonResponse
    {
        $data = $request->validate(['id' => ['nullable', 'integer'], 'code' => ['required', 'alpha_dash', 'max:64'], 'name' => ['required', 'string', 'max:255'], 'kitchen_name' => ['nullable', 'string', 'max:255'], 'price_mode' => ['required', 'in:adjustment,absolute'], 'price_value' => ['required', 'decimal:0,4', 'min:-9999999999'], 'is_default' => ['required', 'boolean'], 'is_active' => ['required', 'boolean'], 'display_order' => ['nullable', 'integer', 'min:0'], 'version' => ['nullable', 'integer', 'min:1']]);
        $variant = DB::transaction(function () use ($data, $menu): ItemVariant {
            $variant = isset($data['id']) ? ItemVariant::query()->where('menu_id', $menu->getKey())->findOrFail($data['id']) : new ItemVariant(['menu_id' => $menu->getKey()]);
            if ($variant->exists && isset($data['version']) && (int) $variant->version !== (int) $data['version']) {
                abort(409, 'Menu configuration changed; refresh before saving.');
            }
            if ($data['is_default']) {
                ItemVariant::query()->where('menu_id', $menu->getKey())->when($variant->exists, fn ($q) => $q->whereKeyNot($variant->getKey()))->update(['is_default' => false]);
            }
            $variant->fill($data);
            $variant->version = $variant->exists ? $variant->version + 1 : 1;
            $variant->saveOrFail();

            return $variant;
        });
        $this->audit->info('restaurant_ops.variant.saved', ['staff_id' => app('admin.auth')->user()?->getKey(), 'menu_id' => $menu->getKey(), 'variant_id' => $variant->getKey(), 'fields' => array_keys($data)]);

        return response()->json(['data' => $variant, 'configuration_hash' => hash('sha256', $variant->toJson())], $variant->wasRecentlyCreated ? 201 : 200);
    }

    public function archiveVariant(Menu $menu, ItemVariant $variant): JsonResponse
    {
        abort_unless((int) $variant->menu_id === (int) $menu->getKey(), 404);
        $variant->forceFill(['is_active' => false, 'is_default' => false, 'archived_at' => now(), 'version' => $variant->version + 1])->saveOrFail();
        $this->audit->info('restaurant_ops.variant.archived', ['staff_id' => app('admin.auth')->user()?->getKey(), 'menu_id' => $menu->getKey(), 'variant_id' => $variant->getKey()]);

        return response()->json(['data' => $variant]);
    }
}
