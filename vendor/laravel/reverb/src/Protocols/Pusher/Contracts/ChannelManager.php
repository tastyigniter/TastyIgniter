<?php

namespace Laravel\Reverb\Protocols\Pusher\Contracts;

use Laravel\Reverb\Application;
use Laravel\Reverb\Contracts\Connection;
use Laravel\Reverb\Protocols\Pusher\Channels\Channel;
use Laravel\Reverb\Protocols\Pusher\Channels\ChannelConnection;

interface ChannelManager
{
    /**
     * Get the application instance.
     */
    public function app(): ?Application;

    /**
     * The application the channel manager should be scoped to.
     */
    public function for(Application $application): ChannelManager;

    /**
     * Get all the channels.
     *
     * @return array<string, Channel>
     */
    public function all(): array;

    /**
     * Determine whether the given channel exists.
     */
    public function exists(string $channel): bool;

    /**
     * Find the given channel.
     */
    public function find(string $channel): ?Channel;

    /**
     * Find the given channel or create it if it doesn't exist.
     */
    public function findOrCreate(string $channel): Channel;

    /**
     * Get all the connections for the given channels.
     *
     * @return array<string, ChannelConnection>
     */
    public function connections(?string $channel = null): array;

    /**
     * Find a single connection by its socket id.
     */
    public function findConnection(string $socketId): ?ChannelConnection;

    /**
     * Unsubscribe from all channels.
     */
    public function unsubscribeFromAll(Connection $connection): void;

    /**
     * Remove the given channel.
     */
    public function remove(Channel $channel): void;

    /**
     * Flush the channel manager repository.
     */
    public function flush(): void;
}
