<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\PaymentBalanceActivityAutomaticSavingsDetail;

/**
 * Builder for model PaymentBalanceActivityAutomaticSavingsDetail
 *
 * @see PaymentBalanceActivityAutomaticSavingsDetail
 */
class PaymentBalanceActivityAutomaticSavingsDetailBuilder
{
    /**
     * @var PaymentBalanceActivityAutomaticSavingsDetail
     */
    private $instance;

    private function __construct(PaymentBalanceActivityAutomaticSavingsDetail $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new payment balance activity automatic savings detail Builder object.
     */
    public static function init(): self
    {
        return new self(new PaymentBalanceActivityAutomaticSavingsDetail());
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
     * Sets payout id field.
     */
    public function payoutId(?string $value): self
    {
        $this->instance->setPayoutId($value);
        return $this;
    }

    /**
     * Unsets payout id field.
     */
    public function unsetPayoutId(): self
    {
        $this->instance->unsetPayoutId();
        return $this;
    }

    /**
     * Initializes a new payment balance activity automatic savings detail object.
     */
    public function build(): PaymentBalanceActivityAutomaticSavingsDetail
    {
        return CoreHelper::clone($this->instance);
    }
}
