<?php

namespace Laravel\Reverb\Protocols\Pusher\Managers;

use Illuminate\Support\Arr;
use Laravel\Reverb\Application;
use Laravel\Reverb\Concerns\InteractsWithApplications;
use Laravel\Reverb\Contracts\ApplicationProvider;
use Laravel\Reverb\Contracts\Connection;
use Laravel\Reverb\Events\ChannelCreated;
use Laravel\Reverb\Events\ChannelRemoved;
use Laravel\Reverb\Protocols\Pusher\Channels\Channel;
use Laravel\Reverb\Protocols\Pusher\Channels\ChannelBroker;
use Laravel\Reverb\Protocols\Pusher\Channels\ChannelConnection;
use Laravel\Reverb\Protocols\Pusher\Contracts\ChannelManager as ChannelManagerInterface;

class ArrayChannelManager implements ChannelManagerInterface
{
    use InteractsWithApplications;

    /**
     * The underlying array of applications and their channels.
     *
     * @var array<string, array<string, array<string, Channel>>>
     */
    protected $applications = [];

    /**
     * The application instance.
     *
     * @var Application
     */
    protected $application;

    /**
     * Get the application instance.
     */
    public function app(): ?Application
    {
        return $this->application;
    }

    /**
     * Get all the channels.
     *
     * @return array<string, Channel>
     */
    public function all(): array
    {
        return $this->channels();
    }

    /**
     * Determine whether the given channel exists.
     */
    public function exists(string $channel): bool
    {
        return isset($this->applications[$this->application->id()][$channel]);
    }

    /**
     * Find the given channel
     */
    public function find(string $channel): ?Channel
    {
        return $this->channels($channel);
    }

    /**
     * Find the given channel or create it if it doesn't exist.
     */
    public function findOrCreate(string $channelName): Channel
    {
        if ($channel = $this->find($channelName)) {
            return $channel;
        }

        $channel = ChannelBroker::create($channelName);

        $this->applications[$this->application->id()][$channel->name()] = $channel;

        ChannelCreated::dispatch($channel);

        return $channel;
    }

    /**
     * Get all of the connections for the given channels.
     *
     * @return array<string, ChannelConnection>
     */
    public function connections(?string $channel = null): array
    {
        $channels = Arr::wrap($this->channels($channel));

        $result = [];

        foreach ($channels as $ch) {
            $result += $ch->connections();
        }

        return $result;
    }

    /**
     * Find a single connection by socket ID.
     */
    public function findConnection(string $socketId): ?ChannelConnection
    {
        foreach ($this->channels() as $channel) {
            if ($connection = $channel->connections()[$socketId] ?? null) {
                return $connection;
            }
        }

        return null;
    }

    /**
     * Unsubscribe from all channels.
     */
    public function unsubscribeFromAll(Connection $connection): void
    {
        foreach ($this->channels() as $channel) {
            $channel->unsubscribe($connection);
        }
    }

    /**
     * Remove the given channel.
     */
    public function remove(Channel $channel): void
    {
        unset($this->applications[$this->application->id()][$channel->name()]);

        ChannelRemoved::dispatch($channel);
    }

    /**
     * Get the given channel.
     */
    public function channel(string $channel): ?Channel
    {
        return $this->channels($channel);
    }

    /**
     * Get the channels for the application.
     *
     * @return Channel|array<string, Channel>|null
     */
    public function channels(?string $channel = null): Channel|array|null
    {
        $channels = $this->applications[$this->application->id()] ?? [];

        if (isset($channel)) {
            return $channels[$channel] ?? null;
        }

        return $channels;
    }

    /**
     * Flush the channel manager repository.
     */
    public function flush(): void
    {
        app(ApplicationProvider::class)
            ->all()
            ->each(function (Application $application) {
                $this->applications[$application->id()] = [];
            });
    }
}
