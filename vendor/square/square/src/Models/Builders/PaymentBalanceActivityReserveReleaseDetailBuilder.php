<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\PaymentBalanceActivityReserveReleaseDetail;

/**
 * Builder for model PaymentBalanceActivityReserveReleaseDetail
 *
 * @see PaymentBalanceActivityReserveReleaseDetail
 */
class PaymentBalanceActivityReserveReleaseDetailBuilder
{
    /**
     * @var PaymentBalanceActivityReserveReleaseDetail
     */
    private $instance;

    private function __construct(PaymentBalanceActivityReserveReleaseDetail $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new payment balance activity reserve release detail Builder object.
     */
    public static function init(): self
    {
        return new self(new PaymentBalanceActivityReserveReleaseDetail());
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
     * Initializes a new payment balance activity reserve release detail object.
     */
    public function build(): PaymentBalanceActivityReserveReleaseDetail
    {
        return CoreHelper::clone($this->instance);
    }
}
