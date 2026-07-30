<?php

namespace Laravel\Reverb\Servers\Reverb\Contracts;

use React\EventLoop\LoopInterface;
use React\Promise\PromiseInterface;

interface PubSubProvider
{
    /**
     * Connect to the publisher.
     */
    public function connect(LoopInterface $loop): void;

    /**
     * Disconnect from the publisher.
     */
    public function disconnect(): void;

    /**
     * Subscribe to the publisher.
     */
    public function subscribe(): void;

    /**
     * Listen for the given event.
     */
    public function on(string $event, callable $callback): void;

    /**
     * Listen for the given event.
     *
     * @alias on
     */
    public function listen(string $event, callable $callback): void;

    /**
     * Stop listening for the given event.
     */
    public function stopListening(string $event): void;

    /**
     * Publish a payload to the publisher.
     */
    public function publish(array $payload): PromiseInterface;
}
