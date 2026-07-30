<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\PauseSubscriptionResponse;
use Square\Models\Subscription;

/**
 * Builder for model PauseSubscriptionResponse
 *
 * @see PauseSubscriptionResponse
 */
class PauseSubscriptionResponseBuilder
{
    /**
     * @var PauseSubscriptionResponse
     */
    private $instance;

    private function __construct(PauseSubscriptionResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new pause subscription response Builder object.
     */
    public static function init(): self
    {
        return new self(new PauseSubscriptionResponse());
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
     * Initializes a new pause subscription response object.
     */
    public function build(): PauseSubscriptionResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
