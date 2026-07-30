<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\UpdateWebhookSubscriptionRequest;
use Square\Models\WebhookSubscription;

/**
 * Builder for model UpdateWebhookSubscriptionRequest
 *
 * @see UpdateWebhookSubscriptionRequest
 */
class UpdateWebhookSubscriptionRequestBuilder
{
    /**
     * @var UpdateWebhookSubscriptionRequest
     */
    private $instance;

    private function __construct(UpdateWebhookSubscriptionRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new update webhook subscription request Builder object.
     */
    public static function init(): self
    {
        return new self(new UpdateWebhookSubscriptionRequest());
    }

    /**
     * Sets subscription field.
     */
    public function subscription(?WebhookSubscription $value): self
    {
        $this->instance->setSubscription($value);
        return $this;
    }

    /**
     * Initializes a new update webhook subscription request object.
     */
    public function build(): UpdateWebhookSubscriptionRequest
    {
        return CoreHelper::clone($this->instance);
    }
}
