<?php

namespace Laravel\Reverb\Servers\Reverb\Publishing;

use Clue\React\Redis\Client;
use React\Promise\Promise;
use React\Promise\PromiseInterface;
use RuntimeException;

class RedisPublishClient extends RedisClient
{
    /**
     * The name of the Redis connection.
     */
    protected string $name = 'publisher';

    /**
     * Stream of events queued while disconnected from Redis.
     */
    protected $queuedEvents = [];

    /**
     * Queue the given publish event.
     */
    protected function queueEvent(array $payload): void
    {
        $this->queuedEvents[] = $payload;
    }

    /**
     * Process the queued events.
     */
    protected function processQueuedEvents(): void
    {
        foreach ($this->queuedEvents as $event) {
            $this->publish($event);
        }

        $this->queuedEvents = [];
    }

    /**
     * Publish an event to the given channel.
     */
    public function publish(array $payload): PromiseInterface
    {
        if (! $this->isConnected($this->client)) {
            $this->queueEvent($payload);

            return new Promise(fn () => new RuntimeException);
        }

        return $this->client->publish($this->channel, json_encode($payload));
    }

    /**
     * Handle a successful connection to the Redis server.
     */
    protected function onConnection(Client $client): void
    {
        parent::onConnection($client);

        $this->processQueuedEvents();
    }
}
