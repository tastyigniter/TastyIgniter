<?php

namespace Laravel\Reverb\Pulse\Recorders;

use Illuminate\Broadcasting\BroadcastManager;
use Illuminate\Contracts\Foundation\Application as Container;
use Laravel\Pulse\Events\IsolatedBeat;
use Laravel\Pulse\Pulse;
use Laravel\Pulse\Recorders\Concerns\Sampling;
use Laravel\Reverb\Application;
use Laravel\Reverb\Contracts\ApplicationProvider;

class ReverbConnections
{
    use Sampling;

    /**
     * The events to listen for.
     *
     * @var class-string
     */
    public string $listen = IsolatedBeat::class;

    /**
     * Create a new recorder instance.
     */
    public function __construct(
        protected Pulse $pulse,
        protected BroadcastManager $broadcast,
        protected Container $app,
    ) {
        //
    }

    /**
     * Record the connection count.
     */
    public function record(IsolatedBeat $event): void
    {
        if ($event->time->second % 15 !== 0) {
            return;
        }

        $this->app->make(ApplicationProvider::class)->all()
            ->each(function (Application $app) use ($event) {
                $connections = $this->broadcast->pusher($app->toArray())
                    ->get('/connections')
                    ->connections;

                $this->pulse->record(
                    type: 'reverb_connections',
                    key: $app->id(),
                    value: $connections,
                    timestamp: $event->time->getTimestamp(),
                )->avg()->max()->onlyBuckets();
            });
    }
}
