<?php

namespace Laravel\Reverb\Concerns;

use Laravel\Reverb\Contracts\ApplicationProvider;

trait SerializesConnections
{
    /**
     * Prepare the connection instance values for serialization.
     *
     * @return array<string, mixed>
     */
    public function __serialize(): array
    {
        return [
            'id' => $this->id(),
            'identifier' => $this->identifier(),
            'application' => $this->app()->id(),
            'origin' => $this->origin(),
            'lastSeenAt' => $this->lastSeenAt,
            'hasBeenPinged' => $this->hasBeenPinged,
        ];
    }

    /**
     * Restore the connection after serialization.
     */
    public function __unserialize(array $values): void
    {
        $this->id = $values['id'];
        $this->identifier = $values['identifier'];
        $this->application = app(ApplicationProvider::class)->findById($values['application']);
        $this->origin = $values['origin'];
        $this->lastSeenAt = $values['lastSeenAt'] ?? null;
        $this->hasBeenPinged = $values['hasBeenPinged'] ?? null;
    }
}
