<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\Subscription;
use Square\Models\SwapPlanResponse;

/**
 * Builder for model SwapPlanResponse
 *
 * @see SwapPlanResponse
 */
class SwapPlanResponseBuilder
{
    /**
     * @var SwapPlanResponse
     */
    private $instance;

    private function __construct(SwapPlanResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new swap plan response Builder object.
     */
    public static function init(): self
    {
        return new self(new SwapPlanResponse());
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
     * Initializes a new swap plan response object.
     */
    public function build(): SwapPlanResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
