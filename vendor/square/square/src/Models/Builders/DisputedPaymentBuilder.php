<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\DisputedPayment;

/**
 * Builder for model DisputedPayment
 *
 * @see DisputedPayment
 */
class DisputedPaymentBuilder
{
    /**
     * @var DisputedPayment
     */
    private $instance;

    private function __construct(DisputedPayment $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new disputed payment Builder object.
     */
    public static function init(): self
    {
        return new self(new DisputedPayment());
    }

    /**
     * Sets payment id field.
     */
    public function paymentId(?string $value): self
    {
        $this->instance->setPaymentId($value);
        return $this;
    }

    /**
     * Unsets payment id field.
     */
    public function unsetPaymentId(): self
    {
        $this->instance->unsetPaymentId();
        return $this;
    }

    /**
     * Initializes a new disputed payment object.
     */
    public function build(): DisputedPayment
    {
        return CoreHelper::clone($this->instance);
    }
}
