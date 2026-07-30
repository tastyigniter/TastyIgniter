<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\ListWebhookSubscriptionsResponse;

/**
 * Builder for model ListWebhookSubscriptionsResponse
 *
 * @see ListWebhookSubscriptionsResponse
 */
class ListWebhookSubscriptionsResponseBuilder
{
    /**
     * @var ListWebhookSubscriptionsResponse
     */
    private $instance;

    private function __construct(ListWebhookSubscriptionsResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new list webhook subscriptions response Builder object.
     */
    public static function init(): self
    {
        return new self(new ListWebhookSubscriptionsResponse());
    }

    /**
     * Sets errors field.
     */
    public function errors(?array $value): self
    {
        $this->instance->setErrors($value);
        return $this;
    }

    /**
     * Sets subscriptions field.
     */
    public function subscriptions(?array $value): self
    {
        $this->instance->setSubscriptions($value);
        return $this;
    }

    /**
     * Sets cursor field.
     */
    public function cursor(?string $value): self
    {
        $this->instance->setCursor($value);
        return $this;
    }

    /**
     * Initializes a new list webhook subscriptions response object.
     */
    public function build(): ListWebhookSubscriptionsResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
