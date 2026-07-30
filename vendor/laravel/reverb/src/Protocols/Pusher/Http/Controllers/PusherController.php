<?php

namespace Laravel\Reverb\Protocols\Pusher\Http\Controllers;

use Laravel\Reverb\Connection as ReverbConnection;
use Laravel\Reverb\Contracts\ApplicationProvider;
use Laravel\Reverb\Exceptions\InvalidApplication;
use Laravel\Reverb\Protocols\Pusher\Server as PusherServer;
use Laravel\Reverb\Servers\Reverb\Connection;
use Psr\Http\Message\RequestInterface;
use Ratchet\RFC6455\Messaging\FrameInterface;

class PusherController
{
    /**
     * Create a new controller instance.
     */
    public function __construct(protected PusherServer $server, protected ApplicationProvider $applications)
    {
        //
    }

    /**
     * Invoke the Reverb WebSocket server.
     */
    public function __invoke(RequestInterface $request, Connection $connection, string $appKey): void
    {
        if (! $reverbConnection = $this->connection($request, $connection, $appKey)) {
            return;
        }

        $connection->withMaxMessageSize($reverbConnection->app()->maxMessageSize());

        $connection->onMessage(
            fn ($message) => $this->server->message($reverbConnection, (string) $message)
        );

        $connection->onControl(
            fn (FrameInterface $message) => $this->server->control($reverbConnection, $message)
        );

        $connection->onClose(
            fn () => $this->server->close($reverbConnection)
        );

        $connection->openBuffer();

        $this->server->open($reverbConnection);
    }

    /**
     * Get the Reverb connection instance for the request.
     */
    protected function connection(RequestInterface $request, Connection $connection, string $key): ?ReverbConnection
    {
        try {
            $application = $this->applications->findByKey($key);
        } catch (InvalidApplication $e) {
            $connection->send('{"event":"pusher:error","data":"{\"code\":4001,\"message\":\"Application does not exist\"}"}');

            return $connection->close();
        }

        return new ReverbConnection(
            $connection,
            $application,
            $request->getHeader('Origin')[0] ?? null
        );
    }
}
