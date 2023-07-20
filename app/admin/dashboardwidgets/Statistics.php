<?php

namespace Admin\DashboardWidgets;

use Admin\Classes\BaseDashboardWidget;
use Admin\Models\Customers_model;
use Admin\Models\Orders_model;
use Admin\Models\Reservations_model;
use Admin\Traits\LocationAwareWidget;
use Igniter\Flame\Exception\SystemException;

/**
 * Statistic dashboard widget.
 */
class Statistics extends BaseDashboardWidget
{
    use LocationAwareWidget;

    /**
     * @var string A unique alias to identify this widget.
     */
    protected $defaultAlias = 'statistics';

    protected $cardDefinition;

    protected static $registeredCards = [];

    public static function registerCards($callback)
    {
        static::$registeredCards[] = $callback;
    }

    /**
     * Renders the widget.
     */
    public function render()
    {
        $this->prepareVars();

        return $this->makePartial('statistics/statistics');
    }

    public function defineProperties()
    {
        return [
            'card' => [
                'label' => 'admin::lang.dashboard.text_stats_card',
                'default' => 'sale',
                'type' => 'select',
                'placeholder' => 'lang:admin::lang.text_please_select',
                'options' => $this->getCardOptions(),
                'validationRule' => 'required|alpha_dash',
            ],
        ];
    }

    public function loadAssets()
    {
        $this->addCss('css/statistics.css', 'statistics-css');
    }

    public function getActiveCard()
    {
        return $this->property('card', 'sale');
    }

    protected function getCardOptions()
    {
        return array_map(function ($context) {
            return array_get($context, 'label');
        }, $this->listCards());
    }

    protected function prepareVars()
    {
        $this->vars['statsContext'] = $context = $this->getActiveCard();
        $this->vars['statsLabel'] = $this->getCardDefinition('label', '--');
        $this->vars['statsColor'] = $this->getCardDefinition('color', 'success');
        $this->vars['statsIcon'] = $this->getCardDefinition('icon', 'fa fa-bar-chart-o');
        $this->vars['statsCount'] = $this->getValue($context);
    }

    protected function listCards()
    {
        $result = $this->getDefaultCards();

        foreach (static::$registeredCards as $callback) {
            foreach ($callback() as $code => $config) {
                $result[$code] = $config;
            }
        }

        return $result;
    }

    protected function getCardDefinition($key, $default = null)
    {
        if (is_null($this->cardDefinition))
            $this->cardDefinition = array_get($this->listCards(), $this->getActiveCard());

        return array_get($this->cardDefinition, $key, $default);
    }

    protected function getValue(string $cardCode): string
    {
        $start = $this->property('startDate', now()->subMonth());
        $end = $this->property('endDate', now());

        if ($dataFromCallable = $this->getCardDefinition('valueFrom')) {
            return $dataFromCallable($cardCode, $start, $end);
        }

        return $this->getValueForDefaultCard($cardCode, $start, $end);
    }

    protected function getValueForDefaultCard(string $cardCode, $start, $end)
    {
        $contextMethod = 'getTotal'.studly_case($cardCode).'Sum';

        throw_unless($this->methodExists($contextMethod), new SystemException(sprintf(
            'The card [%s] does must have a defined method in [%s]',
            $cardCode, get_class($this).'::'.$contextMethod
        )));

        $count = $this->$contextMethod(function ($query) use ($start, $end) {
            $this->locationApplyScope($query);
            $query->whereBetween('created_at', [$start, $end]);
        });

        return empty($count) ? 0 : $count;
    }

    /**
     * Return the total amount of order sales
     *
     * @return string
     */
    protected function getTotalSaleSum(callable $callback)
    {
        $query = Orders_model::query();
        $query->where('status_id', '>', '0')
            ->where('status_id', '!=', setting('canceled_order_status'));

        $callback($query);

        return currency_format($query->sum('order_total') ?? 0);
    }

    /**
     * Return the total amount of lost order sales
     * @return string
     */
    protected function getTotalLostSaleSum(callable $callback)
    {
        $query = Orders_model::query();
        $query->where(function ($query) {
            $query->where('status_id', '<=', '0');
            $query->orWhere('status_id', setting('canceled_order_status'));
        });

        $callback($query);

        return currency_format($query->sum('order_total') ?? 0);
    }

    /**
     * Return the total amount of cash payment order sales
     *
     * @return string
     */
    protected function getTotalCashPaymentSum(callable $callback)
    {
        $query = Orders_model::query();
        $query->where(function ($query) {
            $query->where('status_id', '>', '0');
            $query->where('status_id', '!=', setting('canceled_order_status'));
        })->where('payment', 'cod');

        $callback($query);

        return currency_format($query->sum('order_total') ?? 0);
    }

    /**
     * Return the total number of customers
     *
     * @param callable $callback
     * @return int
     */
    protected function getTotalCustomerSum(callable $callback)
    {
        $query = Customers_model::query();

        $callback($query);

        return $query->count();
    }

    /**
     * Return the total number of orders placed
     *
     * @param callable $callback
     * @return int
     */
    protected function getTotalOrderSum(callable $callback)
    {
        $query = Orders_model::query();

        $callback($query);

        return $query->count();
    }

    /**
     * Return the total number of completed orders
     *
     * @param callable $callback
     * @return int
     */
    protected function getTotalCompletedOrderSum(callable $callback)
    {
        $query = Orders_model::query();
        $query->whereIn('status_id', setting('completed_order_status') ?? []);

        $callback($query);

        return $query->count();
    }

    /**
     * Return the total number of delivery orders
     *
     * @param string $range
     *
     * @return int
     */
    protected function getTotalDeliveryOrderSum(callable $callback)
    {
        $query = Orders_model::query();
        $query->where(function ($query) {
            $query->where('order_type', '1');
            $query->orWhere('order_type', 'delivery');
        });

        $callback($query);

        return currency_format($query->sum('order_total') ?? 0);
    }

    /**
     * Return the total number of collection orders
     *
     * @param callable $callback
     * @return int
     */
    protected function getTotalCollectionOrderSum(callable $callback)
    {
        $query = Orders_model::query();
        $query->where(function ($query) {
            $query->where('order_type', '2');
            $query->orWhere('order_type', 'collection');
        });

        $callback($query);

        return currency_format($query->sum('order_total') ?? 0);
    }

    /**
     * Return the total number of reserved tables
     *
     * @param callable $callback
     * @return int
     */
    protected function getTotalReservedTableSum(callable $callback)
    {
        $query = Reservations_model::with('tables');
        $query->where('status_id', setting('confirmed_reservation_status'));

        $callback($query);

        return $query->get()->pluck('tables')->flatten()->count();
    }

    /**
     * Return the total number of reserved table guests
     *
     * @param callable $callback
     * @return int
     */
    protected function getTotalReservedGuestSum(callable $callback)
    {
        $query = Reservations_model::query();
        $query->where('status_id', setting('confirmed_reservation_status'));

        $callback($query);

        return $query->sum('guest_num') ?? 0;
    }

    /**
     * Return the total number of reservations
     *
     * @param callable $callback
     * @return int
     */
    protected function getTotalReservationSum(callable $callback)
    {
        $query = Reservations_model::query();
        $query->where('status_id', '!=', setting('canceled_reservation_status'));

        $callback($query);

        return $query->count();
    }

    /**
     * Return the total number of completed reservations
     *
     * @param callable $callback
     * @return int
     */
    protected function getTotalCompletedReservationSum(callable $callback)
    {
        $query = Reservations_model::query();
        $query->where('status_id', setting('confirmed_reservation_status'));

        $callback($query);

        return $query->count();
    }

    protected function getDefaultCards(): array
    {
        return [
            'sale' => [
                'label' => 'lang:admin::lang.dashboard.text_total_sale',
                'icon' => ' bg-success text-white fa fa-line-chart',
            ],
            'lost_sale' => [
                'label' => 'lang:admin::lang.dashboard.text_total_lost_sale',
                'icon' => ' bg-danger text-white fa fa-line-chart fa-rotate-180',
            ],
            'cash_payment' => [
                'label' => 'lang:admin::lang.dashboard.text_total_cash_payment',
                'icon' => ' bg-warning text-white fa fa-money-bill',
            ],
            'customer' => [
                'label' => 'lang:admin::lang.dashboard.text_total_customer',
                'icon' => ' bg-info text-white fa fa-users',
            ],
            'order' => [
                'label' => 'lang:admin::lang.dashboard.text_total_order',
                'icon' => ' bg-success text-white fa fa-shopping-cart',
            ],
            'delivery_order' => [
                'label' => 'lang:admin::lang.dashboard.text_total_delivery_order',
                'icon' => ' bg-primary text-white fa fa-truck',
            ],
            'collection_order' => [
                'label' => 'lang:admin::lang.dashboard.text_total_collection_order',
                'icon' => ' bg-info text-white fa fa-shopping-bag',
            ],
            'completed_order' => [
                'label' => 'lang:admin::lang.dashboard.text_total_completed_order',
                'icon' => ' bg-success text-white fa fa-receipt',
            ],
            'reserved_table' => [
                'label' => 'lang:admin::lang.dashboard.text_total_reserved_table',
                'icon' => ' bg-primary text-white fa fa-table',
            ],
            'reserved_guest' => [
                'label' => 'lang:admin::lang.dashboard.text_total_reserved_guest',
                'icon' => ' bg-primary text-white fa fa-table',
            ],
            'reservation' => [
                'label' => 'lang:admin::lang.dashboard.text_total_reservation',
                'icon' => ' bg-success text-white fa fa-table',
            ],
            'completed_reservation' => [
                'label' => 'lang:admin::lang.dashboard.text_total_completed_reservation',
                'icon' => ' bg-success text-white fa fa-table',
            ],
        ];
    }
}
