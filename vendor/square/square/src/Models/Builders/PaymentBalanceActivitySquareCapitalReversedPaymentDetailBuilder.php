<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\PaymentBalanceActivitySquareCapitalReversedPaymentDetail;

/**
 * Builder for model PaymentBalanceActivitySquareCapitalReversedPaymentDetail
 *
 * @see PaymentBalanceActivitySquareCapitalReversedPaymentDetail
 */
class PaymentBalanceActivitySquareCapitalReversedPaymentDetailBuilder
{
    /**
     * @var PaymentBalanceActivitySquareCapitalReversedPaymentDetail
     */
    private $instance;

    private function __construct(PaymentBalanceActivitySquareCapitalReversedPaymentDetail $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new payment balance activity square capital reversed payment detail Builder object.
     */
    public static function init(): self
    {
        return new self(new PaymentBalanceActivitySquareCapitalReversedPaymentDetail());
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
     * Initializes a new payment balance activity square capital reversed payment detail object.
     */
    public function build(): PaymentBalanceActivitySquareCapitalReversedPaymentDetail
    {
        return CoreHelper::clone($this->instance);
    }
}
