<?php

namespace Laravel\Reverb\Servers\Reverb;

use Clue\React\Redis\Client;
use Clue\React\Redis\Factory;
use React\EventLoop\LoopInterface;

class RedisClientFactory
{
    /**
     * Create a new Redis client.
     */
    public function make(LoopInterface $loop, string $redisUrl): Client
    {
        return (new Factory($loop))->createLazyClient(
            $redisUrl
        );
    }
}
