<?php

namespace Laravel\Reverb\Protocols\Pusher\Http\Controllers;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator as ValidatorFacade;
use Laravel\Reverb\Protocols\Pusher\Concerns\InteractsWithChannelInformation;
use Laravel\Reverb\Protocols\Pusher\EventDispatcher;
use Laravel\Reverb\Protocols\Pusher\MetricsHandler;
use Laravel\Reverb\Servers\Reverb\Http\Connection;
use Laravel\Reverb\Servers\Reverb\Http\Response;
use Psr\Http\Message\RequestInterface;
use React\Promise\PromiseInterface;

class EventsController extends Controller
{
    use InteractsWithChannelInformation;

    /**
     * Handle the request.
     */
    public function __invoke(RequestInterface $request, Connection $connection, string $appId): Response|PromiseInterface
    {
        $this->verify($request, $connection, $appId);

        $payload = json_decode($this->body, associative: true, flags: JSON_THROW_ON_ERROR);

        $validator = $this->validator($payload);

        if ($validator->fails()) {
            return new Response($validator->errors(), 422);
        }

        $channels = Arr::wrap($payload['channels'] ?? $payload['channel'] ?? []);
        if ($except = $payload['socket_id'] ?? null) {
            $except = $this->channels->connections()[$except] ?? null;
        }

        EventDispatcher::dispatch(
            $this->application,
            [
                'event' => $payload['name'],
                'channels' => $channels,
                'data' => $payload['data'],
            ],
            $except ? $except->connection() : null,
            $payload['socket_id'] ?? null,
        );

        if (isset($payload['info'])) {
            return app(MetricsHandler::class)
                ->gather($this->application, 'channels', ['info' => $payload['info'], 'channels' => $channels])
                ->then(fn ($channels) => new Response(['channels' => array_map(fn ($channel) => (object) $channel, $channels)]));
        }

        return new Response((object) []);
    }

    /**
     * Create a validator for the incoming request payload.
     */
    protected function validator(array $payload): Validator
    {
        return ValidatorFacade::make($payload, [
            'name' => ['required', 'string'],
            'data' => ['required', 'string'],
            'channels' => ['required_without:channel', 'array'],
            'channel' => ['required_without:channels', 'string'],
            'socket_id' => ['string'],
            'info' => ['string'],
        ]);
    }
}
