<?php

namespace Laravel\Reverb\Exceptions;

use Exception;

class RedisConnectionException extends Exception
{
    /**
     * Timeout while attempting to connect to Redis.
     */
    public static function failedAfter(string $name, int $timeout): self
    {
        return new static("Failed to connect to Redis connection [{$name}] after retrying for {$timeout}s.");
    }
}
