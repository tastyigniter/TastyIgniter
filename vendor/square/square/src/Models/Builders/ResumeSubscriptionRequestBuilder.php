<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\ResumeSubscriptionRequest;

/**
 * Builder for model ResumeSubscriptionRequest
 *
 * @see ResumeSubscriptionRequest
 */
class ResumeSubscriptionRequestBuilder
{
    /**
     * @var ResumeSubscriptionRequest
     */
    private $instance;

    private function __construct(ResumeSubscriptionRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new resume subscription request Builder object.
     */
    public static function init(): self
    {
        return new self(new ResumeSubscriptionRequest());
    }

    /**
     * Sets resume effective date field.
     */
    public function resumeEffectiveDate(?string $value): self
    {
        $this->instance->setResumeEffectiveDate($value);
        return $this;
    }

    /**
     * Unsets resume effective date field.
     */
    public function unsetResumeEffectiveDate(): self
    {
        $this->instance->unsetResumeEffectiveDate();
        return $this;
    }

    /**
     * Sets resume change timing field.
     */
    public function resumeChangeTiming(?string $value): self
    {
        $this->instance->setResumeChangeTiming($value);
        return $this;
    }

    /**
     * Initializes a new resume subscription request object.
     */
    public function build(): ResumeSubscriptionRequest
    {
        return CoreHelper::clone($this->instance);
    }
}
