<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\ResumeSubscriptionResponse;
use Square\Models\Subscription;

/**
 * Builder for model ResumeSubscriptionResponse
 *
 * @see ResumeSubscriptionResponse
 */
class ResumeSubscriptionResponseBuilder
{
    /**
     * @var ResumeSubscriptionResponse
     */
    private $instance;

    private function __construct(ResumeSubscriptionResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new resume subscription response Builder object.
     */
    public static function init(): self
    {
        return new self(new ResumeSubscriptionResponse());
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
     * Initializes a new resume subscription response object.
     */
    public function build(): ResumeSubscriptionResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
