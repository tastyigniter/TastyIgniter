<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\UpdateWebhookSubscriptionResponse;
use Square\Models\WebhookSubscription;

/**
 * Builder for model UpdateWebhookSubscriptionResponse
 *
 * @see UpdateWebhookSubscriptionResponse
 */
class UpdateWebhookSubscriptionResponseBuilder
{
    /**
     * @var UpdateWebhookSubscriptionResponse
     */
    private $instance;

    private function __construct(UpdateWebhookSubscriptionResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new update webhook subscription response Builder object.
     */
    public static function init(): self
    {
        return new self(new UpdateWebhookSubscriptionResponse());
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
     * Sets subscription field.
     */
    public function subscription(?WebhookSubscription $value): self
    {
        $this->instance->setSubscription($value);
        return $this;
    }

    /**
     * Initializes a new update webhook subscription response object.
     */
    public function build(): UpdateWebhookSubscriptionResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
