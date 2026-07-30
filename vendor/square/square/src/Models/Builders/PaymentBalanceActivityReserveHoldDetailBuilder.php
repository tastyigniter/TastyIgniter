<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\PaymentBalanceActivityReserveHoldDetail;

/**
 * Builder for model PaymentBalanceActivityReserveHoldDetail
 *
 * @see PaymentBalanceActivityReserveHoldDetail
 */
class PaymentBalanceActivityReserveHoldDetailBuilder
{
    /**
     * @var PaymentBalanceActivityReserveHoldDetail
     */
    private $instance;

    private function __construct(PaymentBalanceActivityReserveHoldDetail $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new payment balance activity reserve hold detail Builder object.
     */
    public static function init(): self
    {
        return new self(new PaymentBalanceActivityReserveHoldDetail());
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
     * Initializes a new payment balance activity reserve hold detail object.
     */
    public function build(): PaymentBalanceActivityReserveHoldDetail
    {
        return CoreHelper::clone($this->instance);
    }
}
