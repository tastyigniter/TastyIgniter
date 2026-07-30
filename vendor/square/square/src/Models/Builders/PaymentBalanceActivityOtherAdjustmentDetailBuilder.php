<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\PaymentBalanceActivityOtherAdjustmentDetail;

/**
 * Builder for model PaymentBalanceActivityOtherAdjustmentDetail
 *
 * @see PaymentBalanceActivityOtherAdjustmentDetail
 */
class PaymentBalanceActivityOtherAdjustmentDetailBuilder
{
    /**
     * @var PaymentBalanceActivityOtherAdjustmentDetail
     */
    private $instance;

    private function __construct(PaymentBalanceActivityOtherAdjustmentDetail $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new payment balance activity other adjustment detail Builder object.
     */
    public static function init(): self
    {
        return new self(new PaymentBalanceActivityOtherAdjustmentDetail());
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
     * Initializes a new payment balance activity other adjustment detail object.
     */
    public function build(): PaymentBalanceActivityOtherAdjustmentDetail
    {
        return CoreHelper::clone($this->instance);
    }
}
