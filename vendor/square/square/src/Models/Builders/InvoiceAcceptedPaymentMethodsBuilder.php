<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\InvoiceAcceptedPaymentMethods;

/**
 * Builder for model InvoiceAcceptedPaymentMethods
 *
 * @see InvoiceAcceptedPaymentMethods
 */
class InvoiceAcceptedPaymentMethodsBuilder
{
    /**
     * @var InvoiceAcceptedPaymentMethods
     */
    private $instance;

    private function __construct(InvoiceAcceptedPaymentMethods $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new invoice accepted payment methods Builder object.
     */
    public static function init(): self
    {
        return new self(new InvoiceAcceptedPaymentMethods());
    }

    /**
     * Sets card field.
     */
    public function card(?bool $value): self
    {
        $this->instance->setCard($value);
        return $this;
    }

    /**
     * Unsets card field.
     */
    public function unsetCard(): self
    {
        $this->instance->unsetCard();
        return $this;
    }

    /**
     * Sets square gift card field.
     */
    public function squareGiftCard(?bool $value): self
    {
        $this->instance->setSquareGiftCard($value);
        return $this;
    }

    /**
     * Unsets square gift card field.
     */
    public function unsetSquareGiftCard(): self
    {
        $this->instance->unsetSquareGiftCard();
        return $this;
    }

    /**
     * Sets bank account field.
     */
    public function bankAccount(?bool $value): self
    {
        $this->instance->setBankAccount($value);
        return $this;
    }

    /**
     * Unsets bank account field.
     */
    public function unsetBankAccount(): self
    {
        $this->instance->unsetBankAccount();
        return $this;
    }

    /**
     * Sets buy now pay later field.
     */
    public function buyNowPayLater(?bool $value): self
    {
        $this->instance->setBuyNowPayLater($value);
        return $this;
    }

    /**
     * Unsets buy now pay later field.
     */
    public function unsetBuyNowPayLater(): self
    {
        $this->instance->unsetBuyNowPayLater();
        return $this;
    }

    /**
     * Initializes a new invoice accepted payment methods object.
     */
    public function build(): InvoiceAcceptedPaymentMethods
    {
        return CoreHelper::clone($this->instance);
    }
}
