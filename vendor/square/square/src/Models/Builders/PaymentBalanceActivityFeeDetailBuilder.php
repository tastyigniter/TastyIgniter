<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\PaymentBalanceActivityFeeDetail;

/**
 * Builder for model PaymentBalanceActivityFeeDetail
 *
 * @see PaymentBalanceActivityFeeDetail
 */
class PaymentBalanceActivityFeeDetailBuilder
{
    /**
     * @var PaymentBalanceActivityFeeDetail
     */
    private $instance;

    private function __construct(PaymentBalanceActivityFeeDetail $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new payment balance activity fee detail Builder object.
     */
    public static function init(): self
    {
        return new self(new PaymentBalanceActivityFeeDetail());
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
     * Initializes a new payment balance activity fee detail object.
     */
    public function build(): PaymentBalanceActivityFeeDetail
    {
        return CoreHelper::clone($this->instance);
    }
}
