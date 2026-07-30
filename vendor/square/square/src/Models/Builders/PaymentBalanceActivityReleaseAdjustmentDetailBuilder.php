<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\PaymentBalanceActivityReleaseAdjustmentDetail;

/**
 * Builder for model PaymentBalanceActivityReleaseAdjustmentDetail
 *
 * @see PaymentBalanceActivityReleaseAdjustmentDetail
 */
class PaymentBalanceActivityReleaseAdjustmentDetailBuilder
{
    /**
     * @var PaymentBalanceActivityReleaseAdjustmentDetail
     */
    private $instance;

    private function __construct(PaymentBalanceActivityReleaseAdjustmentDetail $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new payment balance activity release adjustment detail Builder object.
     */
    public static function init(): self
    {
        return new self(new PaymentBalanceActivityReleaseAdjustmentDetail());
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
     * Initializes a new payment balance activity release adjustment detail object.
     */
    public function build(): PaymentBalanceActivityReleaseAdjustmentDetail
    {
        return CoreHelper::clone($this->instance);
    }
}
