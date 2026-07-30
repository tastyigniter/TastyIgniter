<?php

declare(strict_types=1);

namespace Igniter\Flame\Traits;

use Illuminate\Broadcasting\PendingBroadcast;

trait EventDispatchable
{
    public static function eventName(): string
    {
        return '';
    }

    public static function dispatchOnce(): mixed
    {
        return static::dispatchEvent(func_get_args(), true);
    }

    public static function dispatch(): ?array
    {
        return static::dispatchEvent(func_get_args());
    }

    public static function dispatchIf($boolean, ...$arguments): ?array
    {
        return $boolean ? static::dispatchEvent($arguments) : null;
    }

    public static function dispatchUnless($boolean, ...$arguments): ?array
    {
        return !$boolean ? static::dispatchEvent($arguments) : null;
    }

    public static function broadcast(): PendingBroadcast
    {
        return broadcast(new static(...func_get_args()));
    }

    protected static function dispatchEvent($arguments, $halt = false): mixed
    {
        $result = [];

        if (!empty($eventName = static::eventName())) {
            $result = event($eventName, $arguments, $halt);
            if ($halt && !is_null($result)) {
                return $result;
            }
        }

        if (!is_null($response = event(new static(...$arguments), [], $halt))) {
            if ($halt) {
                return $response;
            }

            $result = array_merge($result ?? [], $response);
        }

        return $halt ? null : $result;
    }
}
