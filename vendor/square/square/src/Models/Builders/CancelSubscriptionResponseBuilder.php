<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\CancelSubscriptionResponse;
use Square\Models\Subscription;

/**
 * Builder for model CancelSubscriptionResponse
 *
 * @see CancelSubscriptionResponse
 */
class CancelSubscriptionResponseBuilder
{
    /**
     * @var CancelSubscriptionResponse
     */
    private $instance;

    private function __construct(CancelSubscriptionResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new cancel subscription response Builder object.
     */
    public static function init(): self
    {
        return new self(new CancelSubscriptionResponse());
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
     * Sets actions field.
     */
    public function actions(?array $value): self
    {
        $this->instance->setActions($value);
        return $this;
    }

    /**
     * Initializes a new cancel subscription response object.
     */
    public function build(): CancelSubscriptionResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
