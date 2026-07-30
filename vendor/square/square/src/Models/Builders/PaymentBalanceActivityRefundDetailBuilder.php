<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\PaymentBalanceActivityRefundDetail;

/**
 * Builder for model PaymentBalanceActivityRefundDetail
 *
 * @see PaymentBalanceActivityRefundDetail
 */
class PaymentBalanceActivityRefundDetailBuilder
{
    /**
     * @var PaymentBalanceActivityRefundDetail
     */
    private $instance;

    private function __construct(PaymentBalanceActivityRefundDetail $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new payment balance activity refund detail Builder object.
     */
    public static function init(): self
    {
        return new self(new PaymentBalanceActivityRefundDetail());
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
     * Initializes a new payment balance activity refund detail object.
     */
    public function build(): PaymentBalanceActivityRefundDetail
    {
        return CoreHelper::clone($this->instance);
    }
}
