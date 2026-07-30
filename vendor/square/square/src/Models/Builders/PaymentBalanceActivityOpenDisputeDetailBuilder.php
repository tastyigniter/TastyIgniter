<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\PaymentBalanceActivityOpenDisputeDetail;

/**
 * Builder for model PaymentBalanceActivityOpenDisputeDetail
 *
 * @see PaymentBalanceActivityOpenDisputeDetail
 */
class PaymentBalanceActivityOpenDisputeDetailBuilder
{
    /**
     * @var PaymentBalanceActivityOpenDisputeDetail
     */
    private $instance;

    private function __construct(PaymentBalanceActivityOpenDisputeDetail $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new payment balance activity open dispute detail Builder object.
     */
    public static function init(): self
    {
        return new self(new PaymentBalanceActivityOpenDisputeDetail());
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
     * Sets dispute id field.
     */
    public function disputeId(?string $value): self
    {
        $this->instance->setDisputeId($value);
        return $this;
    }

    /**
     * Unsets dispute id field.
     */
    public function unsetDisputeId(): self
    {
        $this->instance->unsetDisputeId();
        return $this;
    }

    /**
     * Initializes a new payment balance activity open dispute detail object.
     */
    public function build(): PaymentBalanceActivityOpenDisputeDetail
    {
        return CoreHelper::clone($this->instance);
    }
}
