<?php

namespace Laravel\Reverb\Servers\Reverb\Concerns;

use GuzzleHttp\Psr7\Message;
use GuzzleHttp\Psr7\Response;
use Laravel\Reverb\Servers\Reverb\Http\Connection;

trait ClosesConnections
{
    /**
     * Close the connection.
     */
    protected function close(Connection $connection, int $statusCode = 400, string $message = '', array $headers = []): void
    {
        $response = new Response($statusCode, $headers, $message);

        $connection->send(Message::toString($response));

        $connection->close();
    }
}
