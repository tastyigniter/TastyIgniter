<?php

declare(strict_types=1);

namespace Igniter\Cart\Listeners;

use Igniter\Admin\DashboardWidgets\Charts;
use Igniter\Cart\Models\Order;
use Igniter\Flame\Database\Builder;
use Igniter\Local\Traits\LocationAwareWidget;
use Illuminate\Support\Facades\DB;

class ExtendDashboardCharts
{
    use LocationAwareWidget;

    public function registerCharts(): void
    {
        Charts::extend(function(Charts $charts): void {
            $charts->bindEvent('charts.extendDatasets', function() use ($charts): void {
                $charts->mergeDataset('reports', 'sets', [
                    'orders' => [
                        'label' => 'lang:igniter.cart::default.dashboard.text_charts_orders',
                        'color' => '#64B5F6',
                        'model' => Order::class,
                        'column' => 'order_date',
                        'priority' => 20,
                    ],
                ]);

                $charts->addDataset('orders_by_day', [
                    'label' => 'lang:igniter.cart::default.dashboard.text_orders_by_day',
                    'type' => 'doughnut',
                    'icon' => ' fa fa-calendar-day',
                    'datasetFrom' => $this->getDatasetConfig(...),
                ]);

                $charts->addDataset('orders_by_hour', [
                    'label' => 'lang:igniter.cart::default.dashboard.text_orders_by_hour',
                    'type' => 'doughnut',
                    'icon' => ' fa fa-hourglass',
                    'datasetFrom' => $this->getDatasetConfig(...),
                ]);

                $charts->addDataset('orders_by_category', [
                    'label' => 'lang:igniter.cart::default.dashboard.text_orders_by_category',
                    'type' => 'pie',
                    'icon' => ' fa fa-utensils',
                    'datasetFrom' => $this->getDatasetConfig(...),
                ]);

                $charts->addDataset('orders_by_payment', [
                    'label' => 'lang:igniter.cart::default.dashboard.text_orders_by_payment',
                    'type' => 'pie',
                    'icon' => ' fa fa-money-check',
                    'datasetFrom' => $this->getDatasetConfig(...),
                ]);
            });
        });
    }

    public function getDatasetConfig($activeDataset, $start, $end): array
    {
        return match ($activeDataset) {
            'orders_by_day' => $this->getOrdersByDayDataset($start, $end),
            'orders_by_hour' => $this->getOrdersByHourDataset($start, $end),
            'orders_by_category' => $this->getOrdersByCategoryDataset($start, $end),
            'orders_by_payment' => $this->getOrdersByPaymentDataset($start, $end),
            default => null,
        };
    }

    /**
     * Return the dataset for orders by day
     */
    protected function getOrdersByDayDataset($start, $end): array
    {
        return $this->getDataset($start, $end, function(Builder $query): void {
            $query->selectRaw('DAYNAME(order_date) as label, COUNT(*) as count');
        });
    }

    /**
     * Return the dataset for orders by hour
     */
    protected function getOrdersByHourDataset($start, $end): array
    {
        return $this->getDataset($start, $end, function(Builder $query): void {
            $query->selectRaw(
                'CONCAT(
                    LPAD(HOUR(TIMESTAMP(order_date, order_time)), 2, "0"), ":00-",
                    LPAD((HOUR(TIMESTAMP(order_date, order_time)) + 1) % 24, 2, "0"), ":00"
                ) as label, COUNT(*) as count',
            );
        });
    }

    /**
     * Return the dataset for orders by category
     */
    protected function getOrdersByCategoryDataset($start, $end): array
    {
        return $this->getDataset($start, $end, function($query): void {
            $orderTable = DB::getTablePrefix().(new Order)->getTable();
            $query->select('c.name as label', DB::raw(sprintf('COUNT(DISTINCT %s.order_id) as count', $orderTable)))
                ->join('order_menus as om', 'orders.order_id', '=', 'om.order_id')
                ->join('menu_categories as mc', 'om.menu_id', '=', 'mc.menu_id')
                ->join('categories as c', 'mc.category_id', '=', 'c.category_id');
        });
    }

    /**
     * Return the dataset for orders by payment type
     */
    protected function getOrdersByPaymentDataset($start, $end): array
    {
        return $this->getDataset($start, $end, function(Builder $query): void {
            $query->select('payments.name as label', DB::raw('COUNT(*) as count'))
                ->join('payments', 'payments.code', '=', 'orders.payment');
        });
    }

    protected function getDataset($start, $end, $callback): array
    {
        $query = Order::query();
        $this->locationApplyScope($query);
        $callback($query);

        $result = $query->whereBetween('order_date', [$start, $end])->groupBy('label')->get();

        return [
            'labels' => $result->map(fn($item) => $item->label)->all(),
            'datasets' => [
                [
                    'backgroundColor' => $result->map(fn($item): string => $this->generateBackgroundColor((string)$item->label))->all(),
                    'data' => $result->map(fn($item) => $item->count)->all(),
                ],
            ],
        ];
    }

    protected function generateBackgroundColor(string $string): string
    {
        return sprintf('hsl(%s, 70%%, 60%%)', crc32('background-color-'.$string) % 360);
    }
}
