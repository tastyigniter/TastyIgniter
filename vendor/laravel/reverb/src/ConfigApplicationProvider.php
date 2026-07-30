<?php

namespace Laravel\Reverb;

use Illuminate\Support\Collection;
use Laravel\Reverb\Contracts\ApplicationProvider;
use Laravel\Reverb\Exceptions\InvalidApplication;

class ConfigApplicationProvider implements ApplicationProvider
{
    /**
     * Create a new config provider instance.
     */
    public function __construct(protected Collection $applications)
    {
        //
    }

    /**
     * Get all of the configured applications as Application instances.
     *
     * @return Collection<Application>
     */
    public function all(): Collection
    {
        return $this->applications->map(function ($app) {
            return $this->findById($app['app_id']);
        });
    }

    /**
     * Find an application instance by ID.
     *
     * @throws InvalidApplication
     */
    public function findById(string $id): Application
    {
        return $this->find('app_id', $id);
    }

    /**
     * Find an application instance by key.
     *
     * @throws InvalidApplication
     */
    public function findByKey(string $key): Application
    {
        return $this->find('key', $key);
    }

    /**
     * Find an application instance.
     *
     * @throws InvalidApplication
     */
    public function find(string $key, mixed $value): Application
    {
        $app = $this->applications->firstWhere($key, $value);

        if (! $app) {
            throw new InvalidApplication;
        }

        return new Application(
            $app['app_id'],
            $app['key'],
            $app['secret'],
            $app['ping_interval'],
            $app['activity_timeout'] ?? 30,
            $app['allowed_origins'],
            $app['max_message_size'],
            $app['max_connections'] ?? null,
            // If no setting is provided, default to allowing all client events...
            $app['accept_client_events_from'] ?? 'all',
            $app['rate_limiting'] ?? null,
            $app['options'] ?? [],
        );
    }
}
