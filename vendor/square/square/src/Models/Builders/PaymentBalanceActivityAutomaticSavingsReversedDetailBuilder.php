<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\PaymentBalanceActivityAutomaticSavingsReversedDetail;

/**
 * Builder for model PaymentBalanceActivityAutomaticSavingsReversedDetail
 *
 * @see PaymentBalanceActivityAutomaticSavingsReversedDetail
 */
class PaymentBalanceActivityAutomaticSavingsReversedDetailBuilder
{
    /**
     * @var PaymentBalanceActivityAutomaticSavingsReversedDetail
     */
    private $instance;

    private function __construct(PaymentBalanceActivityAutomaticSavingsReversedDetail $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new payment balance activity automatic savings reversed detail Builder object.
     */
    public static function init(): self
    {
        return new self(new PaymentBalanceActivityAutomaticSavingsReversedDetail());
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
     * Initializes a new payment balance activity automatic savings reversed detail object.
     */
    public function build(): PaymentBalanceActivityAutomaticSavingsReversedDetail
    {
        return CoreHelper::clone($this->instance);
    }
}
