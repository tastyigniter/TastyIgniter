<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\DeleteWebhookSubscriptionResponse;

/**
 * Builder for model DeleteWebhookSubscriptionResponse
 *
 * @see DeleteWebhookSubscriptionResponse
 */
class DeleteWebhookSubscriptionResponseBuilder
{
    /**
     * @var DeleteWebhookSubscriptionResponse
     */
    private $instance;

    private function __construct(DeleteWebhookSubscriptionResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new delete webhook subscription response Builder object.
     */
    public static function init(): self
    {
        return new self(new DeleteWebhookSubscriptionResponse());
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
     * Initializes a new delete webhook subscription response object.
     */
    public function build(): DeleteWebhookSubscriptionResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
