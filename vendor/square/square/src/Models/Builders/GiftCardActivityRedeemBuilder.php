<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\GiftCardActivityRedeem;
use Square\Models\Money;

/**
 * Builder for model GiftCardActivityRedeem
 *
 * @see GiftCardActivityRedeem
 */
class GiftCardActivityRedeemBuilder
{
    /**
     * @var GiftCardActivityRedeem
     */
    private $instance;

    private function __construct(GiftCardActivityRedeem $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new gift card activity redeem Builder object.
     */
    public static function init(Money $amountMoney): self
    {
        return new self(new GiftCardActivityRedeem($amountMoney));
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
     * Sets status field.
     */
    public function status(?string $value): self
    {
        $this->instance->setStatus($value);
        return $this;
    }

    /**
     * Initializes a new gift card activity redeem object.
     */
    public function build(): GiftCardActivityRedeem
    {
        return CoreHelper::clone($this->instance);
    }
}
