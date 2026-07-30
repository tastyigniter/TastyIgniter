<?php

namespace Laravel\Reverb\Contracts;

interface WebSocketConnection
{
    /**
     * Get the raw socket connection identifier.
     */
    public function id(): int|string;

    /**
     * Send a message to the connection.
     */
    public function send(mixed $message): void;

    /**
     * Close the connection.
     */
    public function close(mixed $message = null): void;
}
