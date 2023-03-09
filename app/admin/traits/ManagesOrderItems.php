<?php

namespace Admin\Traits;

use Admin\Models\Menu_item_option_values_model;
use Admin\Models\Menu_item_options_model;
use Admin\Models\Menus_model;
use Illuminate\Support\Facades\DB;

trait ManagesOrderItems
{
    /**
     * Subtract cart item quantity from menu stock quantity
     *
     * @return void
     */
    public function subtractStock()
    {
        $orderMenuOptions = $this->getOrderMenuOptions();
        $this->getOrderMenus()->each(function ($orderMenu) use ($orderMenuOptions) {
            if (!$menu = Menus_model::find($orderMenu->menu_id))
                return true;

            optional($menu->getStockByLocation($this->location))
                ->updateStockSold($this->getKey(), $orderMenu->quantity);

            $orderMenuOptions
                ->where('order_menu_id', $orderMenu->order_menu_id)
                ->each(function ($orderMenuOption) {
                    if (!$menuItemOptionValue = Menu_item_option_values_model::find(
                        $orderMenuOption->menu_option_value_id
                    )) return true;

                    if (!$menuOptionValue = $menuItemOptionValue->option_value)
                        return true;

                    optional($menuOptionValue->getStockByLocation($this->location))
                        ->updateStockSold($this->getKey(), $orderMenuOption->quantity);
                });
        });
    }

    /**
     * Return all order menu by order_id
     *
     * @return \Illuminate\Support\Collection
     */
    public function getOrderMenus()
    {
        return $this->orderMenusQuery()->where('order_id', $this->getKey())->get();
    }

    /**
     * Return all order menu options by order_id
     *
     * @return \Illuminate\Support\Collection
     */
    public function getOrderMenuOptions()
    {
        return $this->orderMenuOptionsQuery()->where('order_id', $this->getKey())->get()->groupBy('order_menu_id');
    }

    /**
     * Return all order menus merged with order menu options
     *
     * @return \Illuminate\Support\Collection
     */
    public function getOrderMenusWithOptions()
    {
        $orderMenuOptions = $this->getOrderMenuOptions();

        $menuItemOptionsIds = $orderMenuOptions->collapse()->pluck('order_menu_option_id')->unique();

        $menuItemOptions = Menu_item_options_model::with('option')
            ->whereIn('menu_option_id', $menuItemOptionsIds)
            ->get()->keyBy('menu_option_id');

        return $this->getOrderMenus()->map(function ($menu) use ($orderMenuOptions, $menuItemOptions) {
            unset($menu->option_values);
            $menuOptions = $orderMenuOptions->get($menu->order_menu_id) ?: [];

            $menu->menu_options = collect($menuOptions)
                ->map(function ($menuOption) use ($menuItemOptions) {
                    $menuOption->order_option_category = optional($menuItemOptions->get(
                        $menuOption->order_menu_option_id
                    ))->option_name;

                    return $menuOption;
                });

            return $menu;
        });
    }

    /**
     * Return all order totals by order_id
     *
     * @return \Illuminate\Support\Collection
     */
    public function getOrderTotals()
    {
        return $this->orderTotalsQuery()->where('order_id', $this->getKey())->orderBy('priority')->get();
    }

    /**
     * Add cart menu items to order by order_id
     *
     * @param array $content
     *
     * @return float
     */
    public function addOrderMenus(array $content)
    {
        $orderId = $this->getKey();
        if (!is_numeric($orderId))
            return false;

        $this->orderMenusQuery()->where('order_id', $orderId)->delete();
        $this->orderMenuOptionsQuery()->where('order_id', $orderId)->delete();

        foreach ($content as $rowId => $cartItem) {
            if ($rowId != $cartItem->rowId) continue;

            $orderMenuId = $this->orderMenusQuery()->insertGetId([
                'order_id' => $orderId,
                'menu_id' => $cartItem->id,
                'name' => $cartItem->name,
                'quantity' => $cartItem->qty,
                'price' => $cartItem->price,
                'subtotal' => $cartItem->subtotal,
                'comment' => $cartItem->comment,
                'option_values' => serialize($cartItem->options),
            ]);

            if ($orderMenuId && count($cartItem->options)) {
                $this->addOrderMenuOptions($orderMenuId, $cartItem->id, $cartItem->options);
            }
        }
    }

    /**
     * Add cart menu item options to menu and order by,
     * order_id and menu_id
     *
     * @param $orderMenuId
     * @param $menuId
     * @param $options
     *
     * @return bool
     */
    protected function addOrderMenuOptions($orderMenuId, $menuId, $options)
    {
        $orderId = $this->getKey();
        if (!is_numeric($orderId))
            return false;

        foreach ($options as $option) {
            foreach ($option->values as $value) {
                $this->orderMenuOptionsQuery()->insert([
                    'order_menu_id' => $orderMenuId,
                    'order_id' => $orderId,
                    'menu_id' => $menuId,
                    'order_menu_option_id' => $option->id,
                    'menu_option_value_id' => $value->id,
                    'order_option_name' => $value->name,
                    'order_option_price' => $value->price,
                    'quantity' => $value->qty,
                ]);
            }
        }
    }

    /**
     * Add cart totals to order by order_id
     *
     * @param array $totals
     *
     * @return bool
     */
    public function addOrderTotals(array $totals = [])
    {
        $orderId = $this->getKey();
        if (!is_numeric($orderId))
            return false;

        foreach ($totals as $total) {
            $this->addOrUpdateOrderTotal($total);
        }

        $this->calculateTotals();
    }

    public function addOrUpdateOrderTotal(array $total)
    {
        return $this->orderTotalsQuery()->updateOrInsert([
            'order_id' => $this->getKey(),
            'code' => $total['code'],
        ], array_except($total, ['order_id', 'code']));
    }

    public function calculateTotals()
    {
        $subtotal = $this->orderMenusQuery()
            ->where('order_id', $this->getKey())
            ->sum('subtotal');

        $total = $this->orderTotalsQuery()
            ->where('order_id', $this->getKey())
            ->where('is_summable', true)
            ->sum('value');

        $orderTotal = max(0, $subtotal + $total);

        $totalItems = $this->orderMenusQuery()
            ->where('order_id', $this->getKey())
            ->sum('quantity');

        $this->orderTotalsQuery()
            ->where('order_id', $this->getKey())
            ->where('code', 'subtotal')
            ->update(['value' => $subtotal]);

        $this->orderTotalsQuery()
            ->where('order_id', $this->getKey())
            ->where('code', 'total')
            ->update(['value' => $orderTotal]);

        $this->newQuery()->where('order_id', $this->getKey())->update([
            'total_items' => $totalItems,
            'order_total' => $orderTotal,
        ]);
    }

    public function orderMenusQuery()
    {
        return DB::table('order_menus');
    }

    public function orderMenuOptionsQuery()
    {
        return DB::table('order_menu_options');
    }

    public function orderTotalsQuery()
    {
        return DB::table('order_totals');
    }
}
