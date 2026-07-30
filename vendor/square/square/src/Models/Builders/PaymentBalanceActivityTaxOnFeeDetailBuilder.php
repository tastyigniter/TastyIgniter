<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\PaymentBalanceActivityTaxOnFeeDetail;

/**
 * Builder for model PaymentBalanceActivityTaxOnFeeDetail
 *
 * @see PaymentBalanceActivityTaxOnFeeDetail
 */
class PaymentBalanceActivityTaxOnFeeDetailBuilder
{
    /**
     * @var PaymentBalanceActivityTaxOnFeeDetail
     */
    private $instance;

    private function __construct(PaymentBalanceActivityTaxOnFeeDetail $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new payment balance activity tax on fee detail Builder object.
     */
    public static function init(): self
    {
        return new self(new PaymentBalanceActivityTaxOnFeeDetail());
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
     * Sets tax rate description field.
     */
    public function taxRateDescription(?string $value): self
    {
        $this->instance->setTaxRateDescription($value);
        return $this;
    }

    /**
     * Unsets tax rate description field.
     */
    public function unsetTaxRateDescription(): self
    {
        $this->instance->unsetTaxRateDescription();
        return $this;
    }

    /**
     * Initializes a new payment balance activity tax on fee detail object.
     */
    public function build(): PaymentBalanceActivityTaxOnFeeDetail
    {
        return CoreHelper::clone($this->instance);
    }
}
