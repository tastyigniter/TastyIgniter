<?php

namespace Laravel\Reverb\Servers\Reverb\Contracts;

interface PubSubIncomingMessageHandler
{
    /**
     * Handle an incoming message from the PubSub provider.
     */
    public function handle(string $payload): void;

    /**
     * Listen for the given event.
     */
    public function listen(string $event, callable $callback): void;

    /**
     * Stop listening for the given event.
     */
    public function stopListening(string $event): void;
}
