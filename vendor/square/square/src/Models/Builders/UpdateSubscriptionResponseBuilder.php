<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\Subscription;
use Square\Models\UpdateSubscriptionResponse;

/**
 * Builder for model UpdateSubscriptionResponse
 *
 * @see UpdateSubscriptionResponse
 */
class UpdateSubscriptionResponseBuilder
{
    /**
     * @var UpdateSubscriptionResponse
     */
    private $instance;

    private function __construct(UpdateSubscriptionResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new update subscription response Builder object.
     */
    public static function init(): self
    {
        return new self(new UpdateSubscriptionResponse());
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
     * Initializes a new update subscription response object.
     */
    public function build(): UpdateSubscriptionResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
