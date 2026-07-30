<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\CardPaymentTimeline;

/**
 * Builder for model CardPaymentTimeline
 *
 * @see CardPaymentTimeline
 */
class CardPaymentTimelineBuilder
{
    /**
     * @var CardPaymentTimeline
     */
    private $instance;

    private function __construct(CardPaymentTimeline $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new card payment timeline Builder object.
     */
    public static function init(): self
    {
        return new self(new CardPaymentTimeline());
    }

    /**
     * Sets authorized at field.
     */
    public function authorizedAt(?string $value): self
    {
        $this->instance->setAuthorizedAt($value);
        return $this;
    }

    /**
     * Unsets authorized at field.
     */
    public function unsetAuthorizedAt(): self
    {
        $this->instance->unsetAuthorizedAt();
        return $this;
    }

    /**
     * Sets captured at field.
     */
    public function capturedAt(?string $value): self
    {
        $this->instance->setCapturedAt($value);
        return $this;
    }

    /**
     * Unsets captured at field.
     */
    public function unsetCapturedAt(): self
    {
        $this->instance->unsetCapturedAt();
        return $this;
    }

    /**
     * Sets voided at field.
     */
    public function voidedAt(?string $value): self
    {
        $this->instance->setVoidedAt($value);
        return $this;
    }

    /**
     * Unsets voided at field.
     */
    public function unsetVoidedAt(): self
    {
        $this->instance->unsetVoidedAt();
        return $this;
    }

    /**
     * Initializes a new card payment timeline object.
     */
    public function build(): CardPaymentTimeline
    {
        return CoreHelper::clone($this->instance);
    }
}
