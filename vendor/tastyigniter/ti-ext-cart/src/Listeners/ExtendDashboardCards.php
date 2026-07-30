<?php

declare(strict_types=1);

namespace Igniter\Cart\Listeners;

use Igniter\Admin\DashboardWidgets\Statistics;
use Igniter\Cart\Models\Order;
use Igniter\System\Models\Settings;
use Illuminate\Support\Facades\DB;

class ExtendDashboardCards
{
    public function registerCards(): void
    {
        Statistics::registerCards(fn(): array => [
            'sale' => [
                'label' => 'lang:igniter.cart::default.dashboard.text_total_sale',
                'icon' => ' text-success fa fa-4x fa-line-chart',
                'valueFrom' => $this->getValue(...),
            ],
            'lost_sale' => [
                'label' => 'lang:igniter.cart::default.dashboard.text_total_lost_sale',
                'icon' => ' text-danger fa fa-4x fa-line-chart',
                'valueFrom' => $this->getValue(...),
            ],
            'cash_payment' => [
                'label' => 'lang:igniter.cart::default.dashboard.text_total_cash_payment',
                'icon' => ' text-warning fa fa-4x fa-money-bill',
                'valueFrom' => $this->getValue(...),
            ],
            'order' => [
                'label' => 'lang:igniter.cart::default.dashboard.text_total_order',
                'icon' => ' text-success fa fa-4x fa-shopping-cart',
                'valueFrom' => $this->getValue(...),
            ],
            'order_menu_items_count' => [
                'label' => 'lang:igniter.cart::default.dashboard.text_order_menu_items_count',
                'icon' => ' text-success fa fa-4x fa-hashtag',
                'valueFrom' => $this->getValue(...),
            ],
            'delivery_order' => [
                'label' => 'lang:igniter.cart::default.dashboard.text_total_delivery_order',
                'icon' => ' text-primary fa fa-4x fa-truck-fast',
                'valueFrom' => $this->getValue(...),
            ],
            'delivery_order_count' => [
                'label' => 'lang:igniter.cart::default.dashboard.text_delivery_order_count',
                'icon' => ' text-success fa fa-4x fa-truck-fast',
                'valueFrom' => $this->getValue(...),
            ],
            'collection_order' => [
                'label' => 'lang:igniter.cart::default.dashboard.text_total_collection_order',
                'icon' => ' text-success fa fa-4x fa-shopping-bag',
                'valueFrom' => $this->getValue(...),
            ],
            'collection_order_count' => [
                'label' => 'lang:igniter.cart::default.dashboard.text_collection_order_count',
                'icon' => ' text-success fa fa-4x fa-shopping-bag',
                'valueFrom' => $this->getValue(...),
            ],
            'completed_order' => [
                'label' => 'lang:igniter.cart::default.dashboard.text_total_completed_order',
                'icon' => ' text-success fa fa-4x fa-receipt',
                'valueFrom' => $this->getValue(...),
            ],
            'completed_order_count' => [
                'label' => 'lang:igniter.cart::default.dashboard.text_completed_order_count',
                'icon' => ' text-success fa fa-4x fa-receipt',
                'valueFrom' => $this->getValue(...),
            ],
            'canceled_order_total' => [
                'label' => 'lang:igniter.cart::default.dashboard.text_canceled_order_total',
                'icon' => ' text-danger fa fa-4x fa-exclamation-circle',
                'valueFrom' => $this->getValue(...),
            ],
            'canceled_order_count' => [
                'label' => 'lang:igniter.cart::default.dashboard.text_canceled_order_count',
                'icon' => ' text-danger fa fa-4x fa-exclamation-circle',
                'valueFrom' => $this->getValue(...),
            ],
        ]);
    }

    public function getValue($code, $start, $end, callable $callback): string|int
    {
        return match ($code) {
            'sale' => $this->getTotalSaleSum($callback),
            'lost_sale' => $this->getTotalLostSaleSum($callback),
            'cash_payment' => $this->getTotalCashPaymentSum($callback),
            'order' => $this->getTotalOrderSum($callback),
            'order_menu_items_count' => $this->getOrderMenuItemsCount($callback),
            'delivery_order' => $this->getTotalDeliveryOrderSum($callback),
            'delivery_order_count' => $this->getDeliveryOrderCount($callback),
            'collection_order' => $this->getTotalCollectionOrderSum($callback),
            'collection_order_count' => $this->getCollectionOrderCount($callback),
            'completed_order' => $this->getTotalCompletedOrderSum($callback),
            'completed_order_count' => $this->getCompletedOrderCount($callback),
            'canceled_order_total' => $this->getTotalCanceledOrderSum($callback),
            'canceled_order_count' => $this->getCanceledOrderCount($callback),
            default => 0,
        };
    }

    /**
     * Return the total amount of order sales
     */
    protected function getTotalSaleSum(callable $callback): string
    {
        $query = Order::query();
        $query->where('status_id', '>', '0')
            ->where('status_id', '!=', Settings::get('canceled_order_status'));

        $callback($query);

        return currency_format($query->sum('order_total'));
    }

    /**
     * Return the total amount of lost order sales
     */
    protected function getTotalLostSaleSum(callable $callback): string
    {
        $query = Order::query();
        $query->where(function($query): void {
            $query->where('status_id', '<=', '0');
            $query->orWhere('status_id', Settings::get('canceled_order_status'));
        });

        $callback($query);

        return currency_format($query->sum('order_total'));
    }

    /**
     * Return the total amount of cash payment order sales
     */
    protected function getTotalCashPaymentSum(callable $callback): string
    {
        $query = Order::query();
        $query->where(function($query): void {
            $query->where('status_id', '>', '0');
            $query->where('status_id', '!=', Settings::get('canceled_order_status'));
        })->where('payment', 'cod');

        $callback($query);

        return currency_format($query->sum('order_total'));
    }

    /**
     * Return the total number of orders placed
     */
    protected function getTotalOrderSum(callable $callback): int
    {
        $query = Order::query();

        $callback($query);

        return $query->count();
    }

    /**
     * Return the total amount of completed orders
     */
    protected function getTotalCompletedOrderSum(callable $callback): string
    {
        $query = Order::query();
        $query->whereIn('status_id', Settings::get('completed_order_status') ?? []);

        $callback($query);

        return currency_format($query->sum('order_total'));
    }

    /**
     * Return the total number of delivery orders
     */
    protected function getTotalDeliveryOrderSum(callable $callback): string
    {
        $query = Order::query();
        $query->whereIn('status_id', Settings::get('completed_order_status') ?? [])
            ->where(function($query): void {
                $query->where('order_type', '1');
                $query->orWhere('order_type', 'delivery');
            });

        $callback($query);

        return currency_format($query->sum('order_total'));
    }

    /**
     * Return the total number of collection orders
     */
    protected function getTotalCollectionOrderSum(callable $callback): string
    {
        $query = Order::query();
        $query->whereIn('status_id', Settings::get('completed_order_status') ?? [])
            ->where(function($query): void {
                $query->where('order_type', '2');
                $query->orWhere('order_type', 'collection');
            });

        $callback($query);

        return currency_format($query->sum('order_total'));
    }

    /**
     * Return the total number of order menu items
     */
    protected function getOrderMenuItemsCount(callable $callback): int
    {
        $prefix = DB::getTablePrefix();
        $query = Order::query()
            ->selectRaw('SUM('.$prefix.'order_menus.quantity) as total_quantity')
            ->join('order_menus', 'orders.order_id', '=', 'order_menus.order_id')
            ->where('orders.status_id', '>', '0')
            ->where('orders.status_id', '!=', Settings::get('canceled_order_status'));

        $callback($query);

        return (int)$query->value('total_quantity');
    }

    /**
     * Return the total number of delivery orders
     */
    protected function getDeliveryOrderCount(callable $callback): int
    {
        $query = Order::query();
        $query->whereIn('status_id', Settings::get('completed_order_status') ?? [])
            ->where(function($query): void {
                $query->where('order_type', '1');
                $query->orWhere('order_type', 'delivery');
            });

        $callback($query);

        return $query->count();
    }

    /**
     * Return the total number of collection orders
     */
    protected function getCollectionOrderCount(callable $callback): int
    {
        $query = Order::query();
        $query->whereIn('status_id', Settings::get('completed_order_status') ?? [])
            ->where(function($query): void {
                $query->where('order_type', '2');
                $query->orWhere('order_type', 'collection');
            });

        $callback($query);

        return $query->count();
    }

    /**
     * Return the total number of completed order sales
     */
    protected function getCompletedOrderCount(callable $callback): int
    {
        $query = Order::query();
        $query->whereIn('status_id', Settings::get('completed_order_status') ?? []);

        $callback($query);

        return $query->count();
    }

    /**
     * Return the total amount of canceled order sales
     */
    protected function getTotalCanceledOrderSum(callable $callback): string
    {
        $query = Order::query();
        $query->where('status_id', Settings::get('canceled_order_status'));

        $callback($query);

        return currency_format($query->sum('order_total'));
    }

    /**
     * Return the total number of canceled orders
     */
    protected function getCanceledOrderCount(callable $callback): int
    {
        $query = Order::query();
        $query->where('status_id', Settings::get('canceled_order_status'));

        $callback($query);

        return $query->count();
    }
}
