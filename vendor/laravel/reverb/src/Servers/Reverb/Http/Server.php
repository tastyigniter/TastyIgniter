<?php

namespace Laravel\Reverb\Servers\Reverb\Http;

use Illuminate\Support\Str;
use Laravel\Reverb\Loggers\Log;
use Laravel\Reverb\Servers\Reverb\Concerns\ClosesConnections;
use OverflowException;
use Psr\Http\Message\RequestInterface;
use React\EventLoop\Loop;
use React\EventLoop\LoopInterface;
use React\Socket\ConnectionInterface;
use React\Socket\ServerInterface;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

class Server
{
    use ClosesConnections;

    /**
     * Create a new Http server instance.
     */
    public function __construct(protected ServerInterface $socket, protected Router $router, protected int $maxRequestSize, protected ?LoopInterface $loop = null)
    {
        gc_disable();

        $this->loop = $loop ?: Loop::get();

        $this->loop->addPeriodicTimer(30, fn () => gc_collect_cycles());

        // Register __invoke handler for this class to receive new connections...
        $socket->on('connection', $this);
    }

    /**
     * Start the Http server
     */
    public function start(): void
    {
        try {
            $this->loop->run();
        } catch (Throwable $e) {
            Log::error($e->getMessage());
        }
    }

    /**
     * Handle an incoming request.
     */
    protected function handleRequest(string $message, Connection $connection): void
    {
        if ($connection->isConnected()) {
            return;
        }

        if (($request = $this->createRequest($message, $connection)) === null) {
            return;
        }

        $connection->connect();

        try {
            $this->router->dispatch($request, $connection);
        } catch (HttpException $e) {
            $this->close($connection, $e->getStatusCode(), $e->getMessage());
        } catch (Throwable $e) {
            Log::error($e->getMessage());
            $this->close($connection, 500, 'Internal server error.');
        }
    }

    /**
     * Create a Psr7 request from the incoming message.
     */
    protected function createRequest(string $message, Connection $connection): ?RequestInterface
    {
        try {
            $request = Request::from($message, $connection, $this->maxRequestSize);
        } catch (OverflowException $e) {
            $this->close($connection, 413, 'Payload too large.');
        } catch (Throwable $e) {
            $this->close($connection, 400, 'Bad request.');
        }

        return $request ?? null;
    }

    /**
     * Stop the Http server
     */
    public function stop(): void
    {
        $this->loop->stop();

        $this->socket->close();
    }

    /**
     * Invoke the server with a new connection instance.
     */
    public function __invoke(ConnectionInterface $connection): void
    {
        $connection = new Connection($connection);

        $connection->on('data', function ($data) use ($connection) {
            $this->handleRequest($data, $connection);
        });
    }

    /**
     * Determine whether the server has TLS support.
     */
    public function isSecure(): bool
    {
        return Str::startsWith($this->socket->getAddress(), 'tls://');
    }
}
