<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\GiftCardActivityActivate;
use Square\Models\Money;

/**
 * Builder for model GiftCardActivityActivate
 *
 * @see GiftCardActivityActivate
 */
class GiftCardActivityActivateBuilder
{
    /**
     * @var GiftCardActivityActivate
     */
    private $instance;

    private function __construct(GiftCardActivityActivate $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new gift card activity activate Builder object.
     */
    public static function init(): self
    {
        return new self(new GiftCardActivityActivate());
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
     * Sets order id field.
     */
    public function orderId(?string $value): self
    {
        $this->instance->setOrderId($value);
        return $this;
    }

    /**
     * Unsets order id field.
     */
    public function unsetOrderId(): self
    {
        $this->instance->unsetOrderId();
        return $this;
    }

    /**
     * Sets line item uid field.
     */
    public function lineItemUid(?string $value): self
    {
        $this->instance->setLineItemUid($value);
        return $this;
    }

    /**
     * Unsets line item uid field.
     */
    public function unsetLineItemUid(): self
    {
        $this->instance->unsetLineItemUid();
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
     * Sets buyer payment instrument ids field.
     */
    public function buyerPaymentInstrumentIds(?array $value): self
    {
        $this->instance->setBuyerPaymentInstrumentIds($value);
        return $this;
    }

    /**
     * Unsets buyer payment instrument ids field.
     */
    public function unsetBuyerPaymentInstrumentIds(): self
    {
        $this->instance->unsetBuyerPaymentInstrumentIds();
        return $this;
    }

    /**
     * Initializes a new gift card activity activate object.
     */
    public function build(): GiftCardActivityActivate
    {
        return CoreHelper::clone($this->instance);
    }
}
