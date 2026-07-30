<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\GiftCardActivityRefund;
use Square\Models\Money;

/**
 * Builder for model GiftCardActivityRefund
 *
 * @see GiftCardActivityRefund
 */
class GiftCardActivityRefundBuilder
{
    /**
     * @var GiftCardActivityRefund
     */
    private $instance;

    private function __construct(GiftCardActivityRefund $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new gift card activity refund Builder object.
     */
    public static function init(): self
    {
        return new self(new GiftCardActivityRefund());
    }

    /**
     * Sets redeem activity id field.
     */
    public function redeemActivityId(?string $value): self
    {
        $this->instance->setRedeemActivityId($value);
        return $this;
    }

    /**
     * Unsets redeem activity id field.
     */
    public function unsetRedeemActivityId(): self
    {
        $this->instance->unsetRedeemActivityId();
        return $this;
    }

    /**
     * Sets amount money field.
     */
    public function amountMoney(?Money $value): self
    {
        $this->instance->setAmountMoney($value);
        return $this;
    }

    /**
     * Sets reference id field.
     */
    public function referenceId(?string $value): self
    {
        $this->instance->setReferenceId($value);
        return $this;
    }

    /**
     * Unsets reference id field.
     */
    public function unsetReferenceId(): self
    {
        $this->instance->unsetReferenceId();
        return $this;
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
     * Initializes a new gift card activity refund object.
     */
    public function build(): GiftCardActivityRefund
    {
        return CoreHelper::clone($this->instance);
    }
}
