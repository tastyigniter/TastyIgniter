<?php

namespace Laravel\Reverb\Protocols\Pusher\Channels;

use Laravel\Reverb\Contracts\Connection;

class CacheChannel extends Channel
{
    /**
     * Data from last event triggered.
     */
    protected ?array $payload = null;

    /**
     * Send a message to all connections subscribed to the channel.
     */
    public function broadcast(array $payload, ?Connection $except = null): void
    {
        $this->payload = $payload;

        parent::broadcast($payload, $except);
    }

    /**
     * Broadcast a message triggered from an internal source.
     */
    public function broadcastInternally(array $payload, ?Connection $except = null): void
    {
        parent::broadcast($payload, $except);
    }

    /**
     * Determine if the channel has a cached payload.
     */
    public function hasCachedPayload(): bool
    {
        return $this->payload !== null;
    }

    /**
     * Get the cached payload.
     */
    public function cachedPayload(): ?array
    {
        return $this->payload;
    }
}
