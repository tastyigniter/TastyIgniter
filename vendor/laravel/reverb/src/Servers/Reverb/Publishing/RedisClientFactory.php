<?php

namespace Laravel\Reverb\Servers\Reverb\Publishing;

use Clue\React\Redis\Factory;
use React\EventLoop\LoopInterface;
use React\Promise\PromiseInterface;

class RedisClientFactory
{
    /**
     * Create a new Redis client.
     */
    public function make(LoopInterface $loop, string $redisUrl): PromiseInterface
    {
        return (new Factory($loop))->createClient(
            $redisUrl
        );
    }
}
