<?php

namespace Laravel\Reverb\Servers\Reverb\Publishing;

use Clue\React\Redis\Client;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\ConfigurationUrlParser;
use Illuminate\Support\Facades\Config;
use Laravel\Reverb\Exceptions\RedisConnectionException;
use Laravel\Reverb\Loggers\Log;
use React\EventLoop\LoopInterface;

class RedisClient
{
    /**
     * Redis connection client.
     *
     * @var Client
     */
    protected $client;

    /**
     * The name of the Redis connection.
     */
    protected string $name = 'redis';

    /**
     * Determine if the client should attempt to reconnect when disconnected from the server.
     */
    protected bool $shouldRetry = true;

    /**
     * Number of seconds the elapsed since attempting to reconnect.
     */
    protected int $retryTimer = 0;

    /**
     * Create a new instance of the Redis client.
     *
     * @param  callable|null  $onConnect
     */
    public function __construct(
        protected LoopInterface $loop,
        protected RedisClientFactory $clientFactory,
        protected string $channel,
        protected array $server,
        protected $onConnect = null
    ) {
        //
    }

    /**
     * Create a new connetion to the Redis server.
     */
    public function connect(): void
    {
        $this->clientFactory->make($this->loop, $this->redisUrl())->then(
            fn (Client $client) => $this->onConnection($client),
            fn (Exception $exception) => $this->onFailedConnection($exception),
        );
    }

    /**
     * Attempt to reconnect to the Redis server.
     */
    public function reconnect(): void
    {
        if (! $this->shouldRetry) {
            return;
        }

        $this->loop->addTimer(1, fn () => $this->attemptReconnection());
    }

    /**
     * Disconnect from the Redis server.
     */
    public function disconnect(): void
    {
        $this->shouldRetry = false;

        $this->client?->close();
    }

    /**
     * Listen for a given event.
     */
    public function on(string $event, callable $callback): void
    {
        $this->client->on($event, $callback);
    }

    /**
     * Determine if the client is currently connected to the server.
     */
    public function isConnected(): bool
    {
        return (bool) $this->client === true && $this->client instanceof Client;
    }

    /**
     * Handle a connection failure to the Redis server.
     */
    protected function configureClientErrorHandler(): void
    {
        $this->client->on('close', function () {
            $this->client = null;

            Log::info('Disconnected from Redis', "<fg=red>{$this->name}</>");

            $this->reconnect();
        });
    }

    /**
     * Handle a successful connection to the Redis server.
     */
    protected function onConnection(Client $client): void
    {
        $this->client = $client;

        $this->resetRetryTimer();
        $this->configureClientErrorHandler();

        if ($this->onConnect) {
            call_user_func($this->onConnect, $client);
        }

        Log::info('Redis connection established', "<fg=green>{$this->name}</>");
    }

    /**
     * Handle a failed connection to the Redis server.
     */
    protected function onFailedConnection(Exception $exception): void
    {
        $this->client = null;

        Log::error($exception->getMessage());

        $this->reconnect();
    }

    /**
     * Attempt to reconnect to the Redis server until the timeout is reached.
     */
    protected function attemptReconnection(): void
    {
        $this->retryTimer++;

        if ($this->retryTimer >= $this->retryTimeout()) {
            $exception = RedisConnectionException::failedAfter($this->name, $this->retryTimeout());

            Log::error($exception->getMessage());

            throw $exception;
        }

        Log::info('Attempting reconnection to Redis', "<fg=yellow>{$this->name}</>");

        $this->connect();
    }

    /**
     * Determine the configured reconnection timeout.
     */
    protected function retryTimeout(): int
    {
        return (int) ($this->server['timeout'] ?? 60);
    }

    /**
     * Reset the retry connection timer.
     */
    protected function resetRetryTimer(): void
    {
        $this->retryTimer = 0;
    }

    /**
     * Get the connection URL for Redis.
     */
    protected function redisUrl(): string
    {
        $config = empty($this->server) ? Config::get('database.redis.default') : $this->server;

        $parsed = (new ConfigurationUrlParser)->parseConfiguration($config);

        $driver = strtolower($parsed['driver'] ?? '');

        if (in_array($driver, ['tcp', 'tls'])) {
            $parsed['scheme'] = $driver;
        }

        [$host, $port, $protocol, $query] = [
            $parsed['host'],
            $parsed['port'] ?: 6379,
            Arr::get($parsed, 'scheme') === 'tls' ? 's' : '',
            [],
        ];

        if ($parsed['username'] ?? false) {
            $query['username'] = $parsed['username'];
        }

        if ($parsed['password'] ?? false) {
            $query['password'] = $parsed['password'];
        }

        if ($parsed['database'] ?? false) {
            $query['db'] = $parsed['database'];
        }

        $query = http_build_query($query);

        return "redis{$protocol}://{$host}:{$port}".($query ? "?{$query}" : '');
    }
}
