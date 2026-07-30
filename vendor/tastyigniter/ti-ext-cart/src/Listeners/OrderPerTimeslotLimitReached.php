<?php

declare(strict_types=1);

namespace Igniter\Cart\Listeners;

use DateTimeInterface;
use Igniter\Cart\Cart;
use Igniter\Cart\Models\Menu;
use Igniter\Cart\Models\Order;
use Igniter\Flame\Exception\ApplicationException;
use Igniter\Local\Classes\WorkingSchedule;
use Igniter\Local\Facades\Location;
use Igniter\Local\Models\Location as LocationModel;
use Illuminate\Events\Dispatcher;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class OrderPerTimeslotLimitReached
{
    protected static $ordersCache = [];

    protected static $menusCache = [];

    public function subscribe(Dispatcher $events): void
    {
        $events->listen('igniter.workingSchedule.timeslotValid', $this->validateTimeslot(...));
        $events->listen('igniter.checkout.beforeSaveOrder', $this->enforceMaxOrderLimits(...));
        $events->listen('cart.added', $this->enforceMaxCartLimits(...));
        $events->listen('cart.updated', $this->enforceMaxCartLimits(...));
    }

    public function validateTimeslot(WorkingSchedule $schedule, DateTimeInterface $timeslot): ?bool
    {
        // Skip if the working schedule is not for delivery or pickup
        if ($schedule->getType() === LocationModel::OPENING) {
            return null;
        }

        return $this->passesTimeslotLimits($schedule->getType(), $timeslot);
    }

    public function enforceMaxOrderLimits(Order $order, array $data): void
    {
        throw_if($this->passesTimeslotLimits($order->order_type, Location::orderDateTime()) === false,
            new ApplicationException(lang('igniter.cart::default.checkout.alert_maximum_order_reached')),
        );
    }

    public function enforceMaxCartLimits(Cart $cart): null
    {
        if (!Location::current()) {
            return null;
        }

        $orderType = Location::orderType();
        $timeslot = Location::orderDateTime();

        $cartMenuItems = $cart->content()->map(fn($item) => (object)[
            'menu_id' => $item->id,
            'quantity' => $item->qty,
        ])->all();

        throw_if($this->passesTimeslotLimits($orderType, $timeslot, $cartMenuItems) === false,
            new ApplicationException(lang('igniter.cart::default.checkout.alert_maximum_category_reached')),
        );

        return null;
    }

    public static function clearInternalCache(): void
    {
        self::$ordersCache = [];
        self::$menusCache = [];
    }

    protected function passesTimeslotLimits(
        string $orderType,
        DateTimeInterface $timeslot,
        array $additionalMenuItems = [],
    ): ?bool {
        $dateString = Carbon::parse($timeslot)->toDateString();
        $ordersForDate = $this->getOrders($dateString);

        if (!$location = Location::current()) {
            return null;
        }

        [$slotStart, $slotEnd] = $this->getTimeslotBoundaries($timeslot, $orderType, $location);
        $ordersInTimeslot = $this->filterOrdersInSlot($ordersForDate, $slotStart, $slotEnd);

        if (($limitOrdersType = (int)$location->getSettings('checkout.limit_orders')) === 0) {
            return null;
        }

        if ($limitOrdersType === 1) {
            return $this->exceedsTimeslotOrderLimits($ordersInTimeslot, $location) ? false : null;
        }

        $context = (object)[
            'orderLimits' => collect($location->getSettings('checkout.limit_orders_period') ?? []),
            'orderType' => $orderType,
            'slotStart' => $slotStart,
            'dayOfWeek' => $timeslot->format('w'),
            'ordersInSlot' => $ordersInTimeslot,
            'additionalMenuItems' => $additionalMenuItems,
        ];

        return $this->exceedsPeriodOrderLimits($context) ? false : null;
    }

    protected function getTimeslotBoundaries(DateTimeInterface $timeslot, string $orderType, LocationModel $location): array
    {
        $start = Carbon::parse($timeslot);
        $end = $start->clone()
            ->addMinutes($location->getOrderTimeInterval($orderType))
            ->subMinute();

        return [$start, $end];
    }

    protected function filterOrdersInSlot($orders, Carbon $start, Carbon $end)
    {
        return $orders->filter(fn($order): bool => Carbon::parse($start->format('Y-m-d').' '.$order->order_time)
            ->betweenIncluded($start, $end));
    }

    protected function exceedsTimeslotOrderLimits($orders, $location): bool
    {
        $maxOrderCount = (int)$location->getSettings('checkout.limit_orders_count');

        return $orders->count() >= $maxOrderCount;
    }

    protected function exceedsPeriodOrderLimits(object $context): ?bool
    {
        $exceedsLimit = null;

        $context->orderLimits
            ->filter(fn($orderLimit) => array_get($orderLimit, 'status'))
            ->each(function($orderLimit) use (&$exceedsLimit, $context): void {
                if (!$this->matchesLimitDayAndTime($orderLimit, $context->dayOfWeek, $context->slotStart)) {
                    return;
                }

                $limitOrderTypes = array_get($orderLimit, 'order_type', []);
                if (!empty($limitOrderTypes) && !in_array($context->orderType, $limitOrderTypes)) {
                    return;
                }

                if (!empty($limitOrderTypes)) {
                    $context->ordersInSlot = $context->ordersInSlot
                        ->filter(fn($order): bool => in_array($order->order_type, $limitOrderTypes));
                }

                $maxAllowed = (int)array_get($orderLimit, 'max_count');
                $limitType = array_get($orderLimit, 'max_type');

                $currentCount = $this->calculateTotalOrders($limitType, $context, $orderLimit);

                $exceedsLimit = $currentCount >= $maxAllowed;
            });

        return $exceedsLimit;
    }

    protected function matchesLimitDayAndTime(array $limit, string|int $dayOfWeek, Carbon $slotStart): bool
    {
        if (!in_array($dayOfWeek, array_get($limit, 'day_of_week', []))) {
            return false;
        }

        return $slotStart->between(
            Carbon::parse($slotStart->format('Y-m-d').' '.array_get($limit, 'start_time')),
            Carbon::parse($slotStart->format('Y-m-d').' '.array_get($limit, 'end_time')),
        );
    }

    protected function calculateTotalOrders(string $limitType, object $context, array $orderLimit): int
    {
        if ($limitType === 'category') {
            $existingCovers = $this->sumCategoryCovers($context->ordersInSlot, $orderLimit);
            $newCovers = $this->sumCategoryCovers(collect($context->additionalMenuItems), $orderLimit);

            return $existingCovers + $newCovers;
        }

        return $context->ordersInSlot->count() + 1;
    }

    protected function sumCategoryCovers(Collection $orders, array $limit): int
    {
        /** @var int $sum */
        $sum = $orders->reduce(function($total, $order) use ($limit) {
            if (isset($order->menus)) {
                foreach ($order->menus as $menuItem) {
                    if ($this->menuIsInLimitCategories($menuItem->menu_id, $limit)) {
                        $total += $menuItem->quantity;
                    }
                }
            }

            return $total;
        }, 0);

        return $sum;
    }

    protected function menuIsInLimitCategories(string|int $menuId, array $limit): bool
    {
        return $this->getMenuCategories($menuId)->intersect(array_get($limit, 'categories', []))->isNotEmpty();
    }

    protected function getOrders(string $date)
    {
        if (array_has(self::$ordersCache, $date)) {
            return self::$ordersCache[$date];
        }

        $result = Order::query()
            ->with(['menus', 'menu_options'])
            ->select('order_id', 'order_type', 'order_time')
            ->where('location_id', Location::getId())
            ->where('order_date', $date)
            ->whereIn('status_id', array_merge(
                [setting('default_order_status', -1)],
                setting('processing_order_status', []),
                setting('completed_order_status', []),
            ))
            ->get()
            ->map(fn(Order $order) => (object)[
                'order_type' => $order->order_type,
                'order_time' => $order->order_time,
                'menus' => $order->getOrderMenus(),
            ]);

        return self::$ordersCache[$date] = $result;
    }

    protected function getMenuCategories(int|string $menuId)
    {
        if (array_has(self::$menusCache, $menuId)) {
            return self::$menusCache[$menuId];
        }

        $result = Menu::query()->firstWhere('menu_id', $menuId)?->categories()->pluck('categories.category_id');

        return self::$menusCache[$menuId] = $result;
    }
}
