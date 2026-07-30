<?php

namespace Laravel\Reverb\Contracts;

abstract class ServerProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Determine whether the server should publish events.
     */
    public function shouldPublishEvents(): bool
    {
        return false;
    }

    /**
     * Determine whether the server subscribes to events.
     */
    public function subscribesToEvents(): bool
    {
        return $this->shouldPublishEvents();
    }

    /**
     * Determine whether the server should not publish events.
     */
    public function shouldNotPublishEvents(): bool
    {
        return ! $this->shouldPublishEvents();
    }

    /**
     * Determine whether the server should not subscribe to events.
     */
    public function doesNotSubscribeToEvents(): bool
    {
        return ! $this->subscribesToEvents();
    }
}
