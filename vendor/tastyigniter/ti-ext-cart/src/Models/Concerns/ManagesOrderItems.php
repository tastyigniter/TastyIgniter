<?php

declare(strict_types=1);

namespace Igniter\Cart\Models\Concerns;

use Igniter\Cart\Models\Menu;
use Igniter\Cart\Models\MenuItemOptionValue;
use Igniter\Cart\Models\OrderMenu;
use Igniter\Cart\Models\OrderMenuOptionValue;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;
use stdClass;

trait ManagesOrderItems
{
    /**
     * Subtract cart item quantity from menu stock quantity
     */
    public function subtractStock(): void
    {
        $this->getOrderMenus()->each(function($orderMenu) {
            /** @var null|Menu $menu */
            $menu = Menu::find($orderMenu->menu_id);
            if (!$menu) {
                return true;
            }

            $menu->getStockByLocation($this->location)->updateStockSold($this->getKey(), $orderMenu->quantity);

            $this->menu_options
                ->where('order_menu_id', $orderMenu->order_menu_id)
                ->each(function(OrderMenuOptionValue $orderMenuOption) {
                    /** @var null|MenuItemOptionValue $menuItemOptionValue */
                    $menuItemOptionValue = MenuItemOptionValue::find($orderMenuOption->menu_option_value_id);
                    if (!$menuItemOptionValue) {
                        return true;
                    }

                    if (!$menuOptionValue = $menuItemOptionValue->option_value) {
                        return true;
                    }

                    $menuOptionValue->getStockByLocation($this->location)->updateStockSold(
                        $this->getKey(), $orderMenuOption->quantity,
                    );
                });
        });
    }

    /**
     * Return all order menu by order_id
     */
    public function getOrderMenus(): Collection
    {
        return $this->menus;
    }

    /**
     * Return all order menu options by order_id
     */
    public function getOrderMenuOptions(): Collection
    {
        return $this->menu_options->groupBy('order_menu_id');
    }

    /**
     * Return all order menus merged with order menu options
     */
    public function getOrderMenusWithOptions(): Collection
    {
        $this->load('menus.menu_options.menu_option');

        return collect($this->menus)->map(fn(OrderMenu $orderMenu): Arrayable =>
            // Using an anonymous class to avoid setting grouped collection as a relation,
            // which would interfere with Eloquent's lazy loading
            new class($orderMenu->toArray()) implements Arrayable
            {
                public function __construct(protected array $attributes)
                {
                    $this->attributes['menu_options'] = collect($this->attributes['menu_options'] ?? [])
                        ->map(fn(array $orderMenuOptionValue): stdClass => (object)$orderMenuOptionValue)
                        ->groupBy(fn(object $orderMenuOptionValue) => array_get($orderMenuOptionValue->menu_option ?? [], 'option_name'));
                }

                public function toArray(): array
                {
                    return $this->attributes;
                }

                public function __get(string $name): mixed
                {
                    return $this->attributes[$name] ?? null;
                }
            });
    }

    /**
     * Return all order totals by order_id
     */
    public function getOrderTotals(): Collection
    {
        return $this->totals->sortBy('priority');
    }

    /**
     * Add cart menu items to order by order_id
     */
    public function addOrderMenus(array $content): void
    {
        $this->menus()->delete();
        $this->menu_options()->delete();

        foreach ($content as $cartItem) {
            $orderMenu = $this->menus()->create([
                'menu_id' => $cartItem->id,
                'name' => $cartItem->name,
                'quantity' => $cartItem->qty,
                'price' => $cartItem->price,
                'subtotal' => $cartItem->subtotal,
                'comment' => $cartItem->comment,
                'option_values' => serialize($cartItem->options),
            ]);

            if ($orderMenu && count($cartItem->options)) {
                $this->addOrderMenuOptions($orderMenu->getKey(), $cartItem->id, $cartItem->options);
            }
        }
    }

    /**
     * Add cart menu item options to menu and order by,
     * order_id and menu_id
     *
     * @return bool
     */
    protected function addOrderMenuOptions($orderMenuId, $menuId, $menuOptions)
    {
        foreach ($menuOptions as $menuOption) {
            foreach ($menuOption->values as $menuOptionValue) {
                $freeQty = $menuOptionValue->free_qty ?? 0;
                $chargeableQty = max(0, $menuOptionValue->qty - $freeQty);

                $this->menu_options()->create([
                    'order_menu_id' => $orderMenuId,
                    'menu_option_id' => $menuOption->id,
                    'menu_option_value_id' => $menuOptionValue->id,
                    'order_option_name' => $menuOptionValue->name,
                    'order_option_price' => $chargeableQty > 0 ? $menuOptionValue->price : 0,
                    'quantity' => $menuOptionValue->qty,
                    'free_qty' => $freeQty,
                ]);
            }
        }
    }

    /**
     * Add cart totals to order by order_id
     */
    public function addOrderTotals(array $totals = []): void
    {
        foreach ($totals as $total) {
            $this->addOrUpdateOrderTotal($total);
        }

        $this->calculateTotals();
    }

    public function addOrUpdateOrderTotal(array $total)
    {
        return $this->totals()->updateOrCreate([
            'code' => $total['code'],
        ], array_except($total, ['order_id', 'code']));
    }

    public function calculateTotals(): void
    {
        $subtotal = $this->menus()->sum('subtotal');
        $totalItems = $this->menus()->sum('quantity');

        $total = $this->totals()->where('is_summable', true)->sum('value');

        $orderTotal = max(0, $subtotal + $total);

        $this->totals()->where('code', 'subtotal')->update(['value' => $subtotal]);

        $this->totals()
            ->where('order_id', $this->getKey())
            ->where('code', 'total')
            ->update(['value' => $orderTotal]);

        $this->newQuery()->where('order_id', $this->getKey())->update([
            'total_items' => $totalItems,
            'order_total' => $orderTotal,
        ]);
    }
}
