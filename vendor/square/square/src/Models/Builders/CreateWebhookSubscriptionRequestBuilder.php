<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\CreateWebhookSubscriptionRequest;
use Square\Models\WebhookSubscription;

/**
 * Builder for model CreateWebhookSubscriptionRequest
 *
 * @see CreateWebhookSubscriptionRequest
 */
class CreateWebhookSubscriptionRequestBuilder
{
    /**
     * @var CreateWebhookSubscriptionRequest
     */
    private $instance;

    private function __construct(CreateWebhookSubscriptionRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new create webhook subscription request Builder object.
     */
    public static function init(WebhookSubscription $subscription): self
    {
        return new self(new CreateWebhookSubscriptionRequest($subscription));
    }

    /**
     * Sets idempotency key field.
     */
    public function idempotencyKey(?string $value): self
    {
        $this->instance->setIdempotencyKey($value);
        return $this;
    }

    /**
     * Initializes a new create webhook subscription request object.
     */
    public function build(): CreateWebhookSubscriptionRequest
    {
        return CoreHelper::clone($this->instance);
    }
}
