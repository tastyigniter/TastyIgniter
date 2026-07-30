<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\PaymentBalanceActivityThirdPartyFeeRefundDetail;

/**
 * Builder for model PaymentBalanceActivityThirdPartyFeeRefundDetail
 *
 * @see PaymentBalanceActivityThirdPartyFeeRefundDetail
 */
class PaymentBalanceActivityThirdPartyFeeRefundDetailBuilder
{
    /**
     * @var PaymentBalanceActivityThirdPartyFeeRefundDetail
     */
    private $instance;

    private function __construct(PaymentBalanceActivityThirdPartyFeeRefundDetail $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new payment balance activity third party fee refund detail Builder object.
     */
    public static function init(): self
    {
        return new self(new PaymentBalanceActivityThirdPartyFeeRefundDetail());
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
     * Initializes a new payment balance activity third party fee refund detail object.
     */
    public function build(): PaymentBalanceActivityThirdPartyFeeRefundDetail
    {
        return CoreHelper::clone($this->instance);
    }
}
