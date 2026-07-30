<?php

namespace Laravel\Reverb\Protocols\Pusher;

use Laravel\Reverb\Application;
use Laravel\Reverb\Protocols\Pusher\Contracts\ChannelManager;
use Laravel\Reverb\Servers\Reverb\Contracts\PubSubIncomingMessageHandler;

class PusherPubSubIncomingMessageHandler implements PubSubIncomingMessageHandler
{
    protected array $events = [];

    /**
     * Handle an incoming message from the PubSub provider.
     */
    public function handle(string $payload): void
    {
        $event = json_decode($payload, associative: true, flags: JSON_THROW_ON_ERROR);

        $this->processEventListeners($event);

        $application = unserialize($event['application'] ?? null, ['allowed_classes' => [Application::class]]);

        $except = isset($event['socket_id']) ?
            app(ChannelManager::class)->for($application)->findConnection($event['socket_id'])
            : null;

        match ($event['type'] ?? null) {
            'message' => EventDispatcher::dispatchSynchronously(
                $application,
                $event['payload'],
                $except?->connection()
            ),
            'metrics' => app(MetricsHandler::class)->publish(
                unserialize($event['payload'], ['allowed_classes' => [
                    Application::class, PendingMetric::class, MetricType::class,
                ]])
            ),
            'terminate' => collect(app(ChannelManager::class)->for($application)->connections())
                ->each(function ($connection) use ($event) {
                    if ((string) $connection->data()['user_id'] === $event['payload']['user_id']) {
                        $connection->disconnect();
                    }
                }),
            default => null,
        };
    }

    /**
     * Process the given event.
     */
    protected function processEventListeners(array $event): void
    {
        foreach ($this->events as $eventName => $listeners) {
            if (($event['type'] ?? null) === $eventName) {
                foreach ($listeners as $listener) {
                    $listener($event);
                }
            }
        }
    }

    /**
     * Listen for the given event.
     */
    public function listen(string $event, callable $callback): void
    {
        $this->events[$event][] = $callback;
    }

    /**
     * Stop listening for the given event.
     */
    public function stopListening(string $event): void
    {
        unset($this->events[$event]);
    }
}
