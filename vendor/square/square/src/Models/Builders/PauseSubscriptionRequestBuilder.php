<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\PauseSubscriptionRequest;

/**
 * Builder for model PauseSubscriptionRequest
 *
 * @see PauseSubscriptionRequest
 */
class PauseSubscriptionRequestBuilder
{
    /**
     * @var PauseSubscriptionRequest
     */
    private $instance;

    private function __construct(PauseSubscriptionRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new pause subscription request Builder object.
     */
    public static function init(): self
    {
        return new self(new PauseSubscriptionRequest());
    }

    /**
     * Sets pause effective date field.
     */
    public function pauseEffectiveDate(?string $value): self
    {
        $this->instance->setPauseEffectiveDate($value);
        return $this;
    }

    /**
     * Unsets pause effective date field.
     */
    public function unsetPauseEffectiveDate(): self
    {
        $this->instance->unsetPauseEffectiveDate();
        return $this;
    }

    /**
     * Sets pause cycle duration field.
     */
    public function pauseCycleDuration(?int $value): self
    {
        $this->instance->setPauseCycleDuration($value);
        return $this;
    }

    /**
     * Unsets pause cycle duration field.
     */
    public function unsetPauseCycleDuration(): self
    {
        $this->instance->unsetPauseCycleDuration();
        return $this;
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
     * Sets pause reason field.
     */
    public function pauseReason(?string $value): self
    {
        $this->instance->setPauseReason($value);
        return $this;
    }

    /**
     * Unsets pause reason field.
     */
    public function unsetPauseReason(): self
    {
        $this->instance->unsetPauseReason();
        return $this;
    }

    /**
     * Initializes a new pause subscription request object.
     */
    public function build(): PauseSubscriptionRequest
    {
        return CoreHelper::clone($this->instance);
    }
}
