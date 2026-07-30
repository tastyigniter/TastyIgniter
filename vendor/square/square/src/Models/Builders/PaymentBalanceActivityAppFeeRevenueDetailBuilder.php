<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\PaymentBalanceActivityAppFeeRevenueDetail;

/**
 * Builder for model PaymentBalanceActivityAppFeeRevenueDetail
 *
 * @see PaymentBalanceActivityAppFeeRevenueDetail
 */
class PaymentBalanceActivityAppFeeRevenueDetailBuilder
{
    /**
     * @var PaymentBalanceActivityAppFeeRevenueDetail
     */
    private $instance;

    private function __construct(PaymentBalanceActivityAppFeeRevenueDetail $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new payment balance activity app fee revenue detail Builder object.
     */
    public static function init(): self
    {
        return new self(new PaymentBalanceActivityAppFeeRevenueDetail());
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
     * Sets location id field.
     */
    public function locationId(?string $value): self
    {
        $this->instance->setLocationId($value);
        return $this;
    }

    /**
     * Unsets location id field.
     */
    public function unsetLocationId(): self
    {
        $this->instance->unsetLocationId();
        return $this;
    }

    /**
     * Initializes a new payment balance activity app fee revenue detail object.
     */
    public function build(): PaymentBalanceActivityAppFeeRevenueDetail
    {
        return CoreHelper::clone($this->instance);
    }
}
