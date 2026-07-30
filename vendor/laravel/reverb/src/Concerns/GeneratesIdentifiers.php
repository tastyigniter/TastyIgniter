<?php

namespace Laravel\Reverb\Concerns;

trait GeneratesIdentifiers
{
    /**
     * Generate a Pusher-compatible socket ID.
     */
    protected function generateId(): string
    {
        return sprintf('%d.%d', random_int(1, 1_000_000_000), random_int(1, 1_000_000_000));
    }
}
