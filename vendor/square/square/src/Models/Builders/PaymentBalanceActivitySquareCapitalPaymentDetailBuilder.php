<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\PaymentBalanceActivitySquareCapitalPaymentDetail;

/**
 * Builder for model PaymentBalanceActivitySquareCapitalPaymentDetail
 *
 * @see PaymentBalanceActivitySquareCapitalPaymentDetail
 */
class PaymentBalanceActivitySquareCapitalPaymentDetailBuilder
{
    /**
     * @var PaymentBalanceActivitySquareCapitalPaymentDetail
     */
    private $instance;

    private function __construct(PaymentBalanceActivitySquareCapitalPaymentDetail $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new payment balance activity square capital payment detail Builder object.
     */
    public static function init(): self
    {
        return new self(new PaymentBalanceActivitySquareCapitalPaymentDetail());
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
     * Initializes a new payment balance activity square capital payment detail object.
     */
    public function build(): PaymentBalanceActivitySquareCapitalPaymentDetail
    {
        return CoreHelper::clone($this->instance);
    }
}
