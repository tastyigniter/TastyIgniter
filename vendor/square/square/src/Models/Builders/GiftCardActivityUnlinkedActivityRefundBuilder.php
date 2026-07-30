<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\GiftCardActivityUnlinkedActivityRefund;
use Square\Models\Money;

/**
 * Builder for model GiftCardActivityUnlinkedActivityRefund
 *
 * @see GiftCardActivityUnlinkedActivityRefund
 */
class GiftCardActivityUnlinkedActivityRefundBuilder
{
    /**
     * @var GiftCardActivityUnlinkedActivityRefund
     */
    private $instance;

    private function __construct(GiftCardActivityUnlinkedActivityRefund $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new gift card activity unlinked activity refund Builder object.
     */
    public static function init(Money $amountMoney): self
    {
        return new self(new GiftCardActivityUnlinkedActivityRefund($amountMoney));
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
     * Initializes a new gift card activity unlinked activity refund object.
     */
    public function build(): GiftCardActivityUnlinkedActivityRefund
    {
        return CoreHelper::clone($this->instance);
    }
}
