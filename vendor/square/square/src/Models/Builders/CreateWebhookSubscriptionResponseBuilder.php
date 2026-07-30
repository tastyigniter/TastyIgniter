<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\CreateWebhookSubscriptionResponse;
use Square\Models\WebhookSubscription;

/**
 * Builder for model CreateWebhookSubscriptionResponse
 *
 * @see CreateWebhookSubscriptionResponse
 */
class CreateWebhookSubscriptionResponseBuilder
{
    /**
     * @var CreateWebhookSubscriptionResponse
     */
    private $instance;

    private function __construct(CreateWebhookSubscriptionResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new create webhook subscription response Builder object.
     */
    public static function init(): self
    {
        return new self(new CreateWebhookSubscriptionResponse());
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
     * Initializes a new create webhook subscription response object.
     */
    public function build(): CreateWebhookSubscriptionResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
