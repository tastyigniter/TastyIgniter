<?php

declare(strict_types=1);

namespace Igniter\Automation\Classes;

use Igniter\Automation\Jobs\EventParams;
use Igniter\Automation\Models\AutomationRule;
use Igniter\Cart\Models\Order;
use Igniter\Flame\Support\Facades\Igniter;
use Igniter\Reservation\Models\Reservation;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Event;

class EventManager
{
    /**
     * @var array Cache of registration callbacks.
     */
    protected $callbacks = [];

    /**
     * @var bool Internal marker to see if callbacks are run.
     */
    protected $registered = false;

    /**
     * @var array List of registered global params in the system
     */
    protected $registeredGlobalParams;

    public static function bindRules(): void
    {
        foreach (BaseEvent::findEvents() as $eventClass => [$eventCode, $eventObj]) {
            self::bindEvent($eventCode, $eventClass);
        }
    }

    public static function bindEvents(array $events): void
    {
        foreach ($events as $event => $class) {
            self::bindEvent($event, $class);
        }
    }

    public static function bindEvent($eventCode, $eventClass): void
    {
        Event::listen($eventCode, function() use ($eventCode, $eventClass): void {
            if (!method_exists($eventClass, 'makeParamsFromEvent')) {
                return;
            }

            $params = $eventClass::makeParamsFromEvent(func_get_args(), $eventCode);
            (new static)->queueEvent($eventClass, $params);
        });
    }

    public static function fireOrderScheduleEvents(): void
    {
        Order::where('created_at', '>=', now()->subDays(30))
            ->lazy()
            ->each(function($order): void {
                Event::dispatch('automation.order.schedule.hourly', [$order]);
            });
    }

    public static function fireReservationScheduleEvents(): void
    {
        Reservation::where('reserve_date', '>=', now()->subDays(30))
            ->lazy()
            ->each(function($reservation): void {
                Event::dispatch('automation.reservation.schedule.hourly', [$reservation]);
            });
    }

    public function queueEvent($eventClass, array $params): void
    {
        $params += $this->getContextParams();

        // If available, push to queue
        EventParams::dispatch($eventClass, $params)->afterCommit();
    }

    public function fireEvent($eventClass, array $params): void
    {
        $models = AutomationRule::listRulesForEvent($eventClass);

        $models->each(function($model) use ($params): void {
            $model->setEventParams($params);
            $model->triggerRule();
        });
    }

    /**
     * Registers a callback function that defines context variables.
     * The callback function should register context variables by calling the manager's
     * `registerGlobalParams` method. The manager instance is passed to the callback
     * function as an argument. Usage:
     *
     *     Notifier::registerCallback(function($manager){
     *         $manager->registerGlobalParams([...]);
     *     });
     *
     * @param callable $callback A callable function.
     */
    public function registerCallback(callable $callback): void
    {
        $this->callbacks[] = $callback;
    }

    public function registerGlobalParams(array $params): void
    {
        if (!$this->registeredGlobalParams) {
            $this->registeredGlobalParams = [];
        }

        $this->registeredGlobalParams = $params + $this->registeredGlobalParams;
    }

    public function getContextParams()
    {
        $this->processCallbacks();

        $globals = $this->registeredGlobalParams ?: [];

        return [
            'isAdmin' => Igniter::runningInAdmin() ? 1 : 0,
            'isConsole' => App::runningInConsole() ? 1 : 0,
            'appLocale' => App::getLocale(),
        ] + $globals;
    }

    /**
     * Helper to process callbacks once and once only.
     * @return void
     */
    protected function processCallbacks()
    {
        if (!$this->registered) {
            foreach ($this->callbacks as $callback) {
                $callback($this);
            }
        }

        $this->registered = true;
    }
}
