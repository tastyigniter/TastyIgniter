<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\PaymentBalanceActivityDepositFeeDetail;

/**
 * Builder for model PaymentBalanceActivityDepositFeeDetail
 *
 * @see PaymentBalanceActivityDepositFeeDetail
 */
class PaymentBalanceActivityDepositFeeDetailBuilder
{
    /**
     * @var PaymentBalanceActivityDepositFeeDetail
     */
    private $instance;

    private function __construct(PaymentBalanceActivityDepositFeeDetail $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new payment balance activity deposit fee detail Builder object.
     */
    public static function init(): self
    {
        return new self(new PaymentBalanceActivityDepositFeeDetail());
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
     * Initializes a new payment balance activity deposit fee detail object.
     */
    public function build(): PaymentBalanceActivityDepositFeeDetail
    {
        return CoreHelper::clone($this->instance);
    }
}
