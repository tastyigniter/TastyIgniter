<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\TestWebhookSubscriptionRequest;

/**
 * Builder for model TestWebhookSubscriptionRequest
 *
 * @see TestWebhookSubscriptionRequest
 */
class TestWebhookSubscriptionRequestBuilder
{
    /**
     * @var TestWebhookSubscriptionRequest
     */
    private $instance;

    private function __construct(TestWebhookSubscriptionRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new test webhook subscription request Builder object.
     */
    public static function init(): self
    {
        return new self(new TestWebhookSubscriptionRequest());
    }

    /**
     * Sets event type field.
     */
    public function eventType(?string $value): self
    {
        $this->instance->setEventType($value);
        return $this;
    }

    /**
     * Unsets event type field.
     */
    public function unsetEventType(): self
    {
        $this->instance->unsetEventType();
        return $this;
    }

    /**
     * Initializes a new test webhook subscription request object.
     */
    public function build(): TestWebhookSubscriptionRequest
    {
        return CoreHelper::clone($this->instance);
    }
}
