<?php

namespace Laravel\Reverb\Protocols\Pusher\Managers;

use Laravel\Reverb\Contracts\Connection;
use Laravel\Reverb\Protocols\Pusher\Channels\ChannelConnection;
use Laravel\Reverb\Protocols\Pusher\Contracts\ChannelConnectionManager;

class ArrayChannelConnectionManager implements ChannelConnectionManager
{
    /**
     * The channel name.
     */
    protected string $name;

    /**
     * The underlying connections.
     *
     * @var array<string, ChannelConnection>
     */
    protected $connections = [];

    /**
     * Get a channel connection manager for the given channel name.
     */
    public function for(string $name): ChannelConnectionManager
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Add a connection.
     */
    public function add(Connection $connection, array $data): void
    {
        $this->connections[$connection->id()] = new ChannelConnection($connection, $data);
    }

    /**
     * Remove a connection.
     */
    public function remove(Connection $connection): void
    {
        unset($this->connections[$connection->id()]);
    }

    /**
     * Find a connection.
     */
    public function find(Connection $connection): ?ChannelConnection
    {
        return $this->findById($connection->id());
    }

    /**
     * Find a connection by its ID.
     */
    public function findById(string $id): ?ChannelConnection
    {
        return $this->connections[$id] ?? null;
    }

    /**
     * Get all of the connections.
     *
     * @return array<string, ChannelConnection>
     */
    public function all(): array
    {
        return $this->connections;
    }

    /**
     * Determine whether any connections remain on the channel.
     */
    public function isEmpty(): bool
    {
        return empty($this->connections);
    }

    /**
     * Flush the channel connection manager.
     */
    public function flush(): void
    {
        $this->connections = [];
    }
}
