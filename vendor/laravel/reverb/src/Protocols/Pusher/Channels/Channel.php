<?php

namespace Laravel\Reverb\Protocols\Pusher\Channels;

use Laravel\Reverb\Contracts\Connection;
use Laravel\Reverb\Loggers\Log;
use Laravel\Reverb\Protocols\Pusher\Concerns\SerializesChannels;
use Laravel\Reverb\Protocols\Pusher\Contracts\ChannelConnectionManager;
use Laravel\Reverb\Protocols\Pusher\Contracts\ChannelManager;

class Channel
{
    use SerializesChannels;

    /**
     * The channel connections.
     *
     * @var \Laravel\Reverb\Contracts\ChannelConnectionManager
     */
    protected $connections;

    /**
     * Create a new channel instance.
     */
    public function __construct(protected string $name)
    {
        $this->connections = app(ChannelConnectionManager::class)->for($this->name);
    }

    /**
     * Get the channel name.
     */
    public function name(): string
    {
        return $this->name;
    }

    /**
     * Get all connections for the channel.
     *
     * @return array<string, ChannelConnection>
     */
    public function connections(): array
    {
        return $this->connections->all();
    }

    /**
     * Find a connection.
     */
    public function find(Connection $connection): ?ChannelConnection
    {
        return $this->connections->find($connection);
    }

    /**
     * Find a connection by its ID.
     */
    public function findById(string $id): ?ChannelConnection
    {
        return $this->connections->findById($id);
    }

    /**
     * Subscribe to the given channel.
     */
    public function subscribe(Connection $connection, ?string $auth = null, ?string $data = null): void
    {
        $this->connections->add($connection, $data ? json_decode($data, associative: true, flags: JSON_THROW_ON_ERROR) : []);
    }

    /**
     * Unsubscribe from the given channel.
     */
    public function unsubscribe(Connection $connection): void
    {
        $this->connections->remove($connection);

        if ($this->connections->isEmpty()) {
            app(ChannelManager::class)->for($connection->app())->remove($this);
        }
    }

    /**
     * Determine if the connection is subscribed to the channel.
     */
    public function subscribed(Connection $connection): bool
    {
        return $this->connections->find($connection) !== null;
    }

    /**
     * Send a message to all connections subscribed to the channel.
     */
    public function broadcast(array $payload, ?Connection $except = null): void
    {
        if ($except === null) {
            $this->broadcastToAll($payload);

            return;
        }

        $message = json_encode($payload);

        Log::info('Broadcasting To', $this->name());
        Log::message($message);

        foreach ($this->connections() as $connection) {
            if ($except->id() === $connection->id()) {
                continue;
            }

            $connection->send($message);
        }
    }

    /**
     * Send a broadcast to all connections.
     */
    public function broadcastToAll(array $payload): void
    {
        $message = json_encode($payload);

        Log::info('Broadcasting To', $this->name());
        Log::message($message);

        foreach ($this->connections() as $connection) {
            $connection->send($message);
        }
    }

    /**
     * Broadcast a message triggered from an internal source.
     */
    public function broadcastInternally(array $payload, ?Connection $except = null): void
    {
        $this->broadcast($payload, $except);
    }

    /**
     * Get the data associated with the channel.
     */
    public function data(): array
    {
        return [];
    }
}
