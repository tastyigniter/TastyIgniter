<?php

namespace Laravel\Reverb\Protocols\Pusher;

use Illuminate\Support\Str;
use Laravel\Reverb\Application;
use Laravel\Reverb\Protocols\Pusher\Concerns\InteractsWithChannelInformation;
use Laravel\Reverb\Protocols\Pusher\Contracts\ChannelManager;
use Laravel\Reverb\ServerProviderManager;
use Laravel\Reverb\Servers\Reverb\Contracts\PubSubProvider;
use React\Promise\Deferred;
use React\Promise\PromiseInterface;

use function React\Promise\Timer\timeout;

class MetricsHandler
{
    use InteractsWithChannelInformation;

    /**
     * The metrics being gathered.
     *
     * @var array<string, PendingMetric>
     */
    protected array $metrics = [];

    /**
     * Create an instance of the metrics handler.
     */
    public function __construct(
        protected ServerProviderManager $serverProviderManager,
        protected ChannelManager $channels,
        protected PubSubProvider $pubSubProvider
    ) {
        //
    }

    /**
     * Gather the metrics for the given type.
     */
    public function gather(Application $application, string $type, array $options = []): PromiseInterface
    {
        $metric = new PendingMetric(
            Str::random(10),
            $application,
            MetricType::from($type),
            $options
        );

        return $this->serverProviderManager->subscribesToEvents()
            ? $this->gatherMetricsFromSubscribers($metric)
            : $this->promise($this->get($metric));
    }

    /**
     * Get the metrics for the given type.
     */
    public function get(PendingMetric $metric): array
    {
        return match ($metric->type()) {
            MetricType::CHANNEL => $this->channel($metric),
            MetricType::CHANNELS => $this->channels($metric),
            MetricType::CHANNEL_USERS => $this->channelUsers($metric),
            MetricType::CONNECTIONS => $this->connections($metric),
            default => [],
        };
    }

    /**
     * Get the channel for the given application.
     */
    protected function channel(PendingMetric $metric): array
    {
        return $this->info($metric->application(), $metric->option('channel'), $metric->option('info', ''));
    }

    /**
     * Get the channels for the given application.
     */
    protected function channels(PendingMetric $metric): array
    {
        if ($metric->option('channels')) {
            return $this->infoForChannels($metric->application(), $metric->option('channels'), $metric->option('info', ''));
        }

        $channels = collect($this->channels->for($metric->application())->all());

        if ($filter = ($metric->option('filter', false))) {
            $channels = $channels->filter(fn ($channel) => Str::startsWith($channel->name(), $filter));
        }

        $channels = $channels->filter(fn ($channel) => count($channel->connections()) > 0);

        return $this->infoForChannels(
            $metric->application(),
            $channels->all(),
            $metric->option('info', '')
        );
    }

    /**
     * Get the channel users for the given application.
     */
    protected function channelUsers(PendingMetric $metric): array
    {
        $channel = $this->channels->for($metric->application())->find($metric->option('channel'));

        if (! $channel) {
            return [];
        }

        return collect($channel->connections())
            ->map(fn ($connection) => $connection->data())
            ->unique('user_id')
            ->map(fn ($data) => ['id' => $data['user_id']])
            ->values()
            ->all();
    }

    /**
     * Get the connections for the given application.
     */
    protected function connections(PendingMetric $metric): array
    {
        return $this->channels->for($metric->application())->connections();
    }

    /**
     * Gather metrics from all subscribers for the given type.
     */
    protected function gatherMetricsFromSubscribers(PendingMetric $metric): PromiseInterface
    {
        $this->metrics[$metric->key()] = $metric;

        $deferred = $this->listenForMetrics($metric);

        $this->requestMetricsFromSubscribers($metric);

        return timeout($deferred->promise(), 10)->then(
            fn ($metrics) => $metrics,
            fn () => $this->metrics[$metric->key()]?->resolve() ?? [],
        )->then(
            fn ($metrics) => $this->mergeSubscriberMetrics($metrics, $metric->type())
        )->finally(
            fn () => $this->stopListening($metric)
        );
    }

    /**
     * Request metrics from all subscribers.
     */
    protected function requestMetricsFromSubscribers(PendingMetric $metric): void
    {
        $this->pubSubProvider->publish([
            'type' => 'metrics',
            'payload' => serialize($metric),
        ])->then(function ($total) use ($metric) {
            $metric->setSubscriberCount($total);
        });
    }

    /**
     * Merge the given metrics into a single result set.
     */
    protected function mergeSubscriberMetrics(array $metrics, MetricType $type): array
    {
        return match ($type) {
            MetricType::CONNECTIONS => array_reduce($metrics, fn ($carry, $item) => array_merge($carry, $item), []),
            MetricType::CHANNELS => $this->mergeChannels($metrics),
            MetricType::CHANNEL => $this->mergeChannel($metrics),
            MetricType::CHANNEL_USERS => collect($metrics)->flatten(1)->unique()->all(),
            default => [],
        };
    }

    /**
     * Merge multiple channel instances into a single set.
     */
    protected function mergeChannel(array $metrics): array
    {
        return collect($metrics)
            ->reduce(function ($carry, $item) {
                collect($item)->each(fn ($value, $key) => $carry->put($key, match ($key) {
                    'occupied' => $carry->get($key, false) || $value,
                    'user_count' => $carry->get($key, 0) + $value,
                    'subscription_count' => $carry->get($key, 0) + $value,
                    default => $value,
                }));

                return $carry;
            }, collect())
            ->all();
    }

    /**
     * Merge multiple sets of channel instances into a single result set.
     */
    protected function mergeChannels(array $metrics): array
    {
        return collect($metrics)
            ->reduce(function ($carry, $item) {
                collect($item)->each(function ($data, $channel) use ($carry) {
                    $metrics = $carry->get($channel, []);
                    $metrics[] = $data;
                    $carry->put($channel, $metrics);
                });

                return $carry;
            }, collect())
            ->map(fn ($metrics) => $this->mergeChannel($metrics))
            ->all();
    }

    /**
     * Listen for metrics from subscribers.
     */
    protected function listenForMetrics(PendingMetric $metric): Deferred
    {
        $deferred = new Deferred;

        $this->pubSubProvider->on($metric->key(), function ($payload) use ($metric, $deferred) {
            $pending = $this->metrics[$metric->key()];
            $pending->append($payload['payload']);

            if ($pending->resolvable()) {
                $deferred->resolve($pending->resolve());
            }
        });

        return $deferred;
    }

    /**
     * Publish the metrics for the given type.
     */
    public function publish(PendingMetric $metric): void
    {
        $this->pubSubProvider->publish([
            'type' => $metric->key(),
            'payload' => $this->get($metric),
        ]);
    }

    /**
     * Stop listening for the given metric.
     */
    protected function stopListening(PendingMetric $metric): void
    {
        unset($this->metrics[$metric->key()]);
        $this->pubSubProvider->stopListening($metric->key());
    }

    /**
     * Create a promise to resolve the given value.
     */
    protected function promise(mixed $value): PromiseInterface
    {
        $deferred = new Deferred;

        $promise = $deferred->promise();

        $deferred->resolve($value);

        return $promise;
    }
}
