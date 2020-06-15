<?php

namespace Admin\Traits;

use Admin\Models\Coupons_history_model;
use Admin\Models\Menu_item_option_values_model;
use Admin\Models\Menus_model;
use Carbon\Carbon;
use DB;
use Event;
use Igniter\Flame\Cart\CartCondition;
use Igniter\Flame\Cart\CartContent;

trait ManagesOrderItems
{
    public static function bootManagesOrderItems()
    {
        Event::listen('admin.order.beforePaymentProcessed', function (self $model) {
            $model->handleOnBeforePaymentProcessed();
        });
    }

    protected function handleOnBeforePaymentProcessed()
    {
        $this->subtractStock();

        $this->redeemCoupon();
    }

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
                return TRUE;

            if ($menu->subtract_stock)
                $menu->updateStock($orderMenu->quantity);

            $orderMenuOptions
                ->where('order_menu_id', $orderMenu->order_menu_id)
                ->each(function ($orderMenuOption) {
                    if (!$menuOptionValue = Menu_item_option_values_model::find(
                        $orderMenuOption->menu_option_value_id
                    )) return TRUE;

                    $menuOptionValue->updateStock($orderMenuOption->quantity);
                });
        });
    }

    /**
     * Redeem coupon by order_id
     */
    public function redeemCoupon()
    {
        $this
            ->coupon_history()
            ->where('status', '!=', '1')
            ->get()
            ->each(function (Coupons_history_model $model) {
                $model->status = 1;
                $model->date_used = Carbon::now();
                $model->save();

                Event::fire('admin.order.couponRedeemed', [$model]);
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
     * @return bool
     */
    public function addOrderMenus(array $content)
    {
        $orderId = $this->getKey();
        if (!is_numeric($orderId))
            return FALSE;

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

            if ($orderMenuId AND count($cartItem->options)) {
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
            return FALSE;

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
            return FALSE;

        $this->orderTotalsQuery()->where('order_id', $orderId)->delete();

        foreach ($totals as $total) {
            $this->orderTotalsQuery()->insert([
                'order_id' => $orderId,
                'code' => $total['code'],
                'title' => $total['title'],
                'value' => $total['value'],
                'priority' => $total['priority'],
            ]);
        }
    }

    /**
     * Add cart coupon to order by order_id
     *
     * @param \Igniter\Flame\Cart\CartCondition $couponCondition
     * @param \Admin\Models\Customers_model $customer
     *
     * @return int|bool
     */
    public function logCouponHistory($couponCondition, $customer)
    {
        if (!$couponCondition instanceof CartCondition) {
            throw new \InvalidArgumentException(sprintf(
                'Invalid argument, expected %s, got %s',
                CartCondition::class, get_class($couponCondition)
            ));
        }

        if (!$this->exists)
            return FALSE;

        return Coupons_history_model::createHistory($couponCondition, $this, $customer);
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
