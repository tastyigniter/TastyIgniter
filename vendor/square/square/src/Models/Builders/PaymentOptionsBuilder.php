<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\PaymentOptions;

/**
 * Builder for model PaymentOptions
 *
 * @see PaymentOptions
 */
class PaymentOptionsBuilder
{
    /**
     * @var PaymentOptions
     */
    private $instance;

    private function __construct(PaymentOptions $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new payment options Builder object.
     */
    public static function init(): self
    {
        return new self(new PaymentOptions());
    }

    /**
     * Sets autocomplete field.
     */
    public function autocomplete(?bool $value): self
    {
        $this->instance->setAutocomplete($value);
        return $this;
    }

    /**
     * Unsets autocomplete field.
     */
    public function unsetAutocomplete(): self
    {
        $this->instance->unsetAutocomplete();
        return $this;
    }

    /**
     * Sets delay duration field.
     */
    public function delayDuration(?string $value): self
    {
        $this->instance->setDelayDuration($value);
        return $this;
    }

    /**
     * Unsets delay duration field.
     */
    public function unsetDelayDuration(): self
    {
        $this->instance->unsetDelayDuration();
        return $this;
    }

    /**
     * Sets accept partial authorization field.
     */
    public function acceptPartialAuthorization(?bool $value): self
    {
        $this->instance->setAcceptPartialAuthorization($value);
        return $this;
    }

    /**
     * Unsets accept partial authorization field.
     */
    public function unsetAcceptPartialAuthorization(): self
    {
        $this->instance->unsetAcceptPartialAuthorization();
        return $this;
    }

    /**
     * Sets delay action field.
     */
    public function delayAction(?string $value): self
    {
        $this->instance->setDelayAction($value);
        return $this;
    }

    /**
     * Initializes a new payment options object.
     */
    public function build(): PaymentOptions
    {
        return CoreHelper::clone($this->instance);
    }
}
