<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\PaymentBalanceActivityAppFeeRefundDetail;

/**
 * Builder for model PaymentBalanceActivityAppFeeRefundDetail
 *
 * @see PaymentBalanceActivityAppFeeRefundDetail
 */
class PaymentBalanceActivityAppFeeRefundDetailBuilder
{
    /**
     * @var PaymentBalanceActivityAppFeeRefundDetail
     */
    private $instance;

    private function __construct(PaymentBalanceActivityAppFeeRefundDetail $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new payment balance activity app fee refund detail Builder object.
     */
    public static function init(): self
    {
        return new self(new PaymentBalanceActivityAppFeeRefundDetail());
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
     * Sets refund id field.
     */
    public function refundId(?string $value): self
    {
        $this->instance->setRefundId($value);
        return $this;
    }

    /**
     * Unsets refund id field.
     */
    public function unsetRefundId(): self
    {
        $this->instance->unsetRefundId();
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
     * Initializes a new payment balance activity app fee refund detail object.
     */
    public function build(): PaymentBalanceActivityAppFeeRefundDetail
    {
        return CoreHelper::clone($this->instance);
    }
}
