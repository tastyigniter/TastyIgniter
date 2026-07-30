<?php

declare(strict_types=1);

namespace Igniter\Flame\Traits;

use Illuminate\Support\Facades\Event;

/**
 * Adds event related features to any class.
 */
trait EventEmitter
{
    /**
     * Collection of registered events to be fired once only.
     */
    protected array $emitterSingleEvents = [];

    /**
     * Collection of registered events.
     */
    protected array $emitterEvents = [];

    /**
     * Sorted collection of events.
     */
    protected array $emitterEventSorted = [];

    /**
     * Create a new event binding.
     *
     * @param string $event The event name to listen for
     * @param callable $callback The callback to call when emitted
     */
    public function bindEvent(string $event, callable $callback, int $priority = 0): static
    {
        $this->emitterEvents[$event][$priority][] = $callback;
        unset($this->emitterEventSorted[$event]);

        return $this;
    }

    /**
     * Create a new event binding that fires once only
     *
     * @param string $event The event name
     */
    public function bindEventOnce(string $event, callable $callback): static
    {
        $this->emitterSingleEvents[$event][] = $callback;

        return $this;
    }

    /**
     * Sort the listeners for a given event by priority.
     */
    protected function emitterEventSortEvents(string $eventName): void
    {
        $this->emitterEventSorted[$eventName] = [];

        if (isset($this->emitterEvents[$eventName])) {
            krsort($this->emitterEvents[$eventName]);

            $this->emitterEventSorted[$eventName] = array_merge(...$this->emitterEvents[$eventName]);
        }
    }

    /**
     * Destroys an event binding.
     *
     * @param null|string|array $event Event to destroy
     */
    public function unbindEvent(null|string|array $event = null): static
    {
        // Multiple events
        if (is_array($event)) {
            foreach ($event as $_event) {
                $this->unbindEvent($_event);
            }

            return $this;
        }

        if ($event === null) {
            $this->emitterSingleEvents = [];
            $this->emitterEvents = [];
            $this->emitterEventSorted = [];

            return $this;
        }

        if (isset($this->emitterSingleEvents[$event])) {
            unset($this->emitterSingleEvents[$event]);
        }

        if (isset($this->emitterEvents[$event])) {
            unset($this->emitterEvents[$event]);
        }

        if (isset($this->emitterEventSorted[$event])) {
            unset($this->emitterEventSorted[$event]);
        }

        return $this;
    }

    /**
     * Fire an event and call the listeners.
     *
     * @param string $event Event name
     * @param array $params Event parameters
     * @param bool $halt Halt after first non-null result
     *
     * @return mixed Collection of event results / Or single result (if halted)
     */
    public function fireEvent(string $event, array $params = [], bool $halt = false): mixed
    {
        $result = [];

        // Single events
        if (isset($this->emitterSingleEvents[$event])) {
            foreach ($this->emitterSingleEvents[$event] as $callback) {
                $response = call_user_func_array($callback, $params);
                if (is_null($response)) {
                    continue;
                }

                if ($halt) {
                    unset($this->emitterSingleEvents[$event]);

                    return $response;
                }

                $result[] = $response;
            }

            unset($this->emitterSingleEvents[$event]);
        }

        // Recurring events, with priority
        if (isset($this->emitterEvents[$event])) {
            if (!isset($this->emitterEventSorted[$event])) {
                $this->emitterEventSortEvents($event);
            }

            foreach ($this->emitterEventSorted[$event] as $callback) {
                $response = call_user_func_array($callback, $params);
                if (is_null($response)) {
                    continue;
                }

                if ($halt) {
                    return $response;
                }

                $result[] = $response;
            }
        }

        return $halt ? null : $result;
    }

    /**
     * Fires a combination of local and global events. The first segment is removed
     * from the event name locally and the local object is passed as the first
     * argument to the event globally. Halting is also enabled by default.
     *
     * For example:
     *
     *     $this->fireSystemEvent('admin.form.myEvent', ['my value']);
     *
     * Is equivalent to:
     *
     *     $this->fireEvent('form.myEvent', ['myvalue'], true);
     *
     *     Event::dispatch('admin.form.myEvent', [$this, 'myvalue'], true);
     *
     * @param string $event Event name
     * @param array $params Event parameters
     * @param bool $halt Halt after first non-null result
     */
    public function fireSystemEvent(string $event, array $params = [], bool $halt = true): mixed
    {
        $result = [];

        $shortEvent = substr($event, strpos($event, '.') + 1);

        $longArgs = array_merge([$this], $params);

        // Local event first
        if (!is_null($response = $this->fireEvent($shortEvent, $params, $halt))) {
            if ($halt) {
                return $response;
            }

            if ($response !== false) {
                $result = array_merge($result, $response);
            }
        }

        // Global event second
        if (!is_null($response = Event::dispatch($event, $longArgs, $halt))) {
            if ($halt) {
                return $response;
            }

            if ($response !== false) {
                $result = array_merge($result, $response);
            }
        }

        return $result;
    }
}
