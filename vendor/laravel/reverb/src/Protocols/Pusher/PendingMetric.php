<?php

namespace Laravel\Reverb\Protocols\Pusher;

use Laravel\Reverb\Application;

class PendingMetric
{
    /**
     * The number of subscribers for the metric.
     */
    protected ?int $subscribers = null;

    /**
     * The data for the metric.
     */
    protected array $data = [];

    /**
     * Instantiate a new pending metric.
     */
    public function __construct(
        protected string $key,
        protected Application $application,
        protected MetricType $type,
        protected array $options = [],
    ) {
        //
    }

    /**
     * Get the metric key.
     */
    public function key(): string
    {
        return $this->key;
    }

    /**
     * Get the metric type.
     */
    public function type(): MetricType
    {
        return $this->type;
    }

    /**
     * Get the application for the metric.
     */
    public function application(): Application
    {
        return $this->application;
    }

    /**
     * Get an option for the metric.
     */
    public function option(string $key, mixed $default = null): mixed
    {
        return $this->options[$key] ?? $default;
    }

    /**
     * Get the options for the metric.
     */
    public function options(): array
    {
        return $this->options;
    }

    /**
     * Set the subscriber count for the metric.
     */
    public function setSubscriberCount(int $count): void
    {
        $this->subscribers = $count;
    }

    /**
     * Append data to the metric.
     */
    public function append(array $data): void
    {
        $this->data[] = $data;
    }

    /**
     * Check if the metric is resolvable.
     */
    public function resolvable(): bool
    {
        return $this->subscribers !== null && count($this->data) === $this->subscribers;
    }

    /**
     * Resolve the data for the metric.
     */
    public function resolve(): array
    {
        return $this->data;
    }
}
