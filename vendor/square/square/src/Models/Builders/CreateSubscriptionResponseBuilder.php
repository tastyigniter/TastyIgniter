<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\CreateSubscriptionResponse;
use Square\Models\Subscription;

/**
 * Builder for model CreateSubscriptionResponse
 *
 * @see CreateSubscriptionResponse
 */
class CreateSubscriptionResponseBuilder
{
    /**
     * @var CreateSubscriptionResponse
     */
    private $instance;

    private function __construct(CreateSubscriptionResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new create subscription response Builder object.
     */
    public static function init(): self
    {
        return new self(new CreateSubscriptionResponse());
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
    public function subscription(?Subscription $value): self
    {
        $this->instance->setSubscription($value);
        return $this;
    }

    /**
     * Initializes a new create subscription response object.
     */
    public function build(): CreateSubscriptionResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
