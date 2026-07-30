<?php

namespace Laravel\Reverb\Contracts;

use Illuminate\Support\Collection;
use Laravel\Reverb\Application;
use Laravel\Reverb\Exceptions\InvalidApplication;

interface ApplicationProvider
{
    /**
     * Get all of the configured applications as Application instances.
     *
     * @return Collection<Application>
     */
    public function all(): Collection;

    /**
     * Find an application instance by ID.
     *
     * @throws InvalidApplication
     */
    public function findById(string $id): Application;

    /**
     * Find an application instance by key.
     *
     * @throws InvalidApplication
     */
    public function findByKey(string $key): Application;
}
