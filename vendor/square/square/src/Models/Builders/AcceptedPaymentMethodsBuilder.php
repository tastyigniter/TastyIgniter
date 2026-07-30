<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\AcceptedPaymentMethods;

/**
 * Builder for model AcceptedPaymentMethods
 *
 * @see AcceptedPaymentMethods
 */
class AcceptedPaymentMethodsBuilder
{
    /**
     * @var AcceptedPaymentMethods
     */
    private $instance;

    private function __construct(AcceptedPaymentMethods $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new accepted payment methods Builder object.
     */
    public static function init(): self
    {
        return new self(new AcceptedPaymentMethods());
    }

    /**
     * Sets apple pay field.
     */
    public function applePay(?bool $value): self
    {
        $this->instance->setApplePay($value);
        return $this;
    }

    /**
     * Unsets apple pay field.
     */
    public function unsetApplePay(): self
    {
        $this->instance->unsetApplePay();
        return $this;
    }

    /**
     * Sets google pay field.
     */
    public function googlePay(?bool $value): self
    {
        $this->instance->setGooglePay($value);
        return $this;
    }

    /**
     * Unsets google pay field.
     */
    public function unsetGooglePay(): self
    {
        $this->instance->unsetGooglePay();
        return $this;
    }

    /**
     * Sets cash app pay field.
     */
    public function cashAppPay(?bool $value): self
    {
        $this->instance->setCashAppPay($value);
        return $this;
    }

    /**
     * Unsets cash app pay field.
     */
    public function unsetCashAppPay(): self
    {
        $this->instance->unsetCashAppPay();
        return $this;
    }

    /**
     * Sets afterpay clearpay field.
     */
    public function afterpayClearpay(?bool $value): self
    {
        $this->instance->setAfterpayClearpay($value);
        return $this;
    }

    /**
     * Unsets afterpay clearpay field.
     */
    public function unsetAfterpayClearpay(): self
    {
        $this->instance->unsetAfterpayClearpay();
        return $this;
    }

    /**
     * Initializes a new accepted payment methods object.
     */
    public function build(): AcceptedPaymentMethods
    {
        return CoreHelper::clone($this->instance);
    }
}
