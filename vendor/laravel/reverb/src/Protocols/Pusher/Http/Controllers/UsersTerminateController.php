<?php

namespace Laravel\Reverb\Protocols\Pusher\Http\Controllers;

use Laravel\Reverb\ServerProviderManager;
use Laravel\Reverb\Servers\Reverb\Contracts\PubSubProvider;
use Laravel\Reverb\Servers\Reverb\Http\Connection;
use Laravel\Reverb\Servers\Reverb\Http\Response;
use Psr\Http\Message\RequestInterface;
use React\Promise\PromiseInterface;

class UsersTerminateController extends Controller
{
    /**
     * Handle the request.
     */
    public function __invoke(RequestInterface $request, Connection $connection, string $appId, string $userId): Response|PromiseInterface
    {
        $this->verify($request, $connection, $appId);

        if (app(ServerProviderManager::class)->subscribesToEvents()) {
            return app(PubSubProvider::class)->publish([
                'type' => 'terminate',
                'application' => serialize($this->application),
                'payload' => ['user_id' => $userId],
            ])->then(fn () => new Response((object) []));
        }

        $connections = collect($this->channels->connections());

        $connections->each(function ($connection) use ($userId) {
            if ((string) $connection->data()['user_id'] === $userId) {
                $connection->disconnect();
            }
        });

        return new Response((object) []);
    }
}
