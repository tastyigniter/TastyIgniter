<?php

declare(strict_types=1);

namespace Igniter\Flame\Pagic\Concerns;

use Closure;
use Illuminate\Contracts\Events\Dispatcher;

trait HasEvents
{
    /**
     * The event map for the model.
     *
     * Allows for object-based events for native Eloquent events.
     */
    protected array $dispatchesEvents = [];

    /**
     * User exposed observable events.
     *
     * These are extra user-defined events observers may subscribe to.
     */
    protected array $observables = [];

    /**
     * Register an observer with the Model.
     */
    public static function observe(string|object $class): void
    {
        $instance = new static;

        $className = is_string($class) ? $class : $class::class;

        // When registering a model observer, we will spin through the possible events
        // and determine if this observer has that method. If it does, we will hook
        // it into the model's event system, making it convenient to watch these.
        foreach ($instance->getObservableEvents() as $event) {
            if (method_exists($class, $event)) {
                static::registerModelEvent($event, $className.'@'.$event);
            }
        }
    }

    /**
     * Get the observable event names.
     */
    public function getObservableEvents(): array
    {
        return array_merge(
            [
                'retrieved', 'creating', 'created', 'updating',
                'updated', 'deleting', 'deleted', 'saving',
                'saved', 'restoring', 'restored',
            ],
            $this->observables,
        );
    }

    /**
     * Set the observable event names.
     */
    public function setObservableEvents(array $observables): self
    {
        $this->observables = $observables;

        return $this;
    }

    /**
     * Add an observable event name.
     *
     * @param array|mixed $observables
     */
    public function addObservableEvents(mixed $observables): void
    {
        $this->observables = array_unique(array_merge(
            $this->observables, is_array($observables) ? $observables : func_get_args(),
        ));
    }

    /**
     * Remove an observable event name.
     */
    public function removeObservableEvents(mixed $observables): void
    {
        $this->observables = array_diff(
            $this->observables, is_array($observables) ? $observables : func_get_args(),
        );
    }

    /**
     * Register a model event with the dispatcher.
     */
    protected static function registerModelEvent(string $event, string|Closure $callback)
    {
        if (isset(static::$dispatcher)) {
            $name = static::class;

            static::$dispatcher->listen(sprintf('pagic.%s: %s', $event, $name), $callback);
        }
    }

    /**
     * Bind some nicer events to this model, in the format of method overrides.
     */
    protected function bootNicerEvents()
    {
        $class = static::class;

        if (isset(static::$eventsBooted[$class])) {
            return;
        }

        $radicals = ['creat', 'sav', 'updat', 'delet', 'retriev'];
        $hooks = ['before' => 'ing', 'after' => 'ed'];

        foreach ($radicals as $radical) {
            foreach ($hooks as $hook => $event) {

                $eventMethod = $radical.$event; // saving / saved
                $method = $hook.ucfirst($radical); // beforeSave / afterSave
                $method .= 'e';

                self::$eventMethod(function($model) use ($method) {
                    $model->fireEvent('model.'.$method);

                    if ($model->methodExists($method)) {
                        return $model->$method();
                    }
                });
            }
        }

        /*
         * Hook to boot events
         */
        static::registerModelEvent('booted', function($model) {
            $model->fireEvent('model.afterBoot');
            if ($model->methodExists('afterBoot')) {
                return $model->afterBoot();
            }
        });

        static::$eventsBooted[$class] = true;
    }

    /**
     * Fire the given event for the model.
     */
    protected function fireModelEvent(string $event, bool $halt = true): mixed
    {
        if (!isset(static::$dispatcher)) {
            return true;
        }

        // First, we will get the proper method to call on the event dispatcher, and then we
        // will attempt to fire a custom, object based event for the given event. If that
        // returns a result we can return that result, or we'll call the string events.
        $method = $halt ? 'until' : 'dispatch';

        return static::$dispatcher->{$method}(sprintf('pagic.%s: ', $event).static::class, $this);
    }

    /**
     * Create a new native event for handling beforeFetch().
     */
    public static function retrieving(string|Closure $callback): void
    {
        static::registerModelEvent('retrieving', $callback);
    }

    /**
     * Register a retrieved model event with the dispatcher.
     */
    public static function retrieved(string|Closure $callback): void
    {
        static::registerModelEvent('retrieved', $callback);
    }

    /**
     * Register a saving model event with the dispatcher.
     */
    public static function saving(string|Closure $callback): void
    {
        static::registerModelEvent('saving', $callback);
    }

    /**
     * Register a saved model event with the dispatcher.
     */
    public static function saved(string|Closure $callback): void
    {
        static::registerModelEvent('saved', $callback);
    }

    /**
     * Register an updating model event with the dispatcher.
     */
    public static function updating(string|Closure $callback): void
    {
        static::registerModelEvent('updating', $callback);
    }

    /**
     * Register an updated model event with the dispatcher.
     */
    public static function updated(string|Closure $callback): void
    {
        static::registerModelEvent('updated', $callback);
    }

    /**
     * Register a creating model event with the dispatcher.
     */
    public static function creating(string|Closure $callback): void
    {
        static::registerModelEvent('creating', $callback);
    }

    /**
     * Register a created model event with the dispatcher.
     */
    public static function created(string|Closure $callback): void
    {
        static::registerModelEvent('created', $callback);
    }

    /**
     * Register a deleting model event with the dispatcher.
     */
    public static function deleting(string|Closure $callback): void
    {
        static::registerModelEvent('deleting', $callback);
    }

    /**
     * Register a deleted model event with the dispatcher.
     */
    public static function deleted(string|Closure $callback): void
    {
        static::registerModelEvent('deleted', $callback);
    }

    /**
     * Remove all the event listeners for the model.
     */
    public static function flushEventListeners(): void
    {
        $instance = new static;

        if (isset(static::$dispatcher)) {
            foreach ($instance->getObservableEvents() as $event) {
                static::$dispatcher->forget(sprintf('eloquent.%s: ', $event).static::class);
            }
        }
    }

    /**
     * Get the event dispatcher instance.
     */
    public static function getEventDispatcher(): Dispatcher
    {
        return static::$dispatcher;
    }

    /**
     * Set the event dispatcher instance.
     */
    public static function setEventDispatcher(Dispatcher $dispatcher): void
    {
        static::$dispatcher = $dispatcher;
    }

    /**
     * Unset the event dispatcher for models.
     */
    public static function unsetEventDispatcher(): void
    {
        static::$dispatcher = null;
    }
}
