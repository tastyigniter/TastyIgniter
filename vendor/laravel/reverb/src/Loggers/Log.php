<?php

namespace Laravel\Reverb\Loggers;

use Laravel\Reverb\Contracts\Logger;

class Log
{
    /**
     * The logger instance.
     *
     * @var Logger
     */
    protected static $logger;

    /**
     * Proxy method calls to the logger instance.
     *
     * @param  string  $method
     * @param  array  $arguments
     * @return mixed
     */
    public static function __callStatic($method, $arguments)
    {
        static::$logger ??= app(Logger::class);

        return static::$logger->{$method}(...$arguments);
    }
}
