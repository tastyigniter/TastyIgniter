<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\PaymentBalanceActivityChargeDetail;

/**
 * Builder for model PaymentBalanceActivityChargeDetail
 *
 * @see PaymentBalanceActivityChargeDetail
 */
class PaymentBalanceActivityChargeDetailBuilder
{
    /**
     * @var PaymentBalanceActivityChargeDetail
     */
    private $instance;

    private function __construct(PaymentBalanceActivityChargeDetail $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new payment balance activity charge detail Builder object.
     */
    public static function init(): self
    {
        return new self(new PaymentBalanceActivityChargeDetail());
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
     * Initializes a new payment balance activity charge detail object.
     */
    public function build(): PaymentBalanceActivityChargeDetail
    {
        return CoreHelper::clone($this->instance);
    }
}
