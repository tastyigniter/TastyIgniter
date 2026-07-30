<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\CheckoutOptions;
use Square\Models\PaymentLink;
use Square\Models\PrePopulatedData;

/**
 * Builder for model PaymentLink
 *
 * @see PaymentLink
 */
class PaymentLinkBuilder
{
    /**
     * @var PaymentLink
     */
    private $instance;

    private function __construct(PaymentLink $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new payment link Builder object.
     */
    public static function init(int $version): self
    {
        return new self(new PaymentLink($version));
    }

    /**
     * Sets id field.
     */
    public function id(?string $value): self
    {
        $this->instance->setId($value);
        return $this;
    }

    /**
     * Sets description field.
     */
    public function description(?string $value): self
    {
        $this->instance->setDescription($value);
        return $this;
    }

    /**
     * Unsets description field.
     */
    public function unsetDescription(): self
    {
        $this->instance->unsetDescription();
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
     * Sets checkout options field.
     */
    public function checkoutOptions(?CheckoutOptions $value): self
    {
        $this->instance->setCheckoutOptions($value);
        return $this;
    }

    /**
     * Sets pre populated data field.
     */
    public function prePopulatedData(?PrePopulatedData $value): self
    {
        $this->instance->setPrePopulatedData($value);
        return $this;
    }

    /**
     * Sets url field.
     */
    public function url(?string $value): self
    {
        $this->instance->setUrl($value);
        return $this;
    }

    /**
     * Sets long url field.
     */
    public function longUrl(?string $value): self
    {
        $this->instance->setLongUrl($value);
        return $this;
    }

    /**
     * Sets created at field.
     */
    public function createdAt(?string $value): self
    {
        $this->instance->setCreatedAt($value);
        return $this;
    }

    /**
     * Sets updated at field.
     */
    public function updatedAt(?string $value): self
    {
        $this->instance->setUpdatedAt($value);
        return $this;
    }

    /**
     * Sets payment note field.
     */
    public function paymentNote(?string $value): self
    {
        $this->instance->setPaymentNote($value);
        return $this;
    }

    /**
     * Unsets payment note field.
     */
    public function unsetPaymentNote(): self
    {
        $this->instance->unsetPaymentNote();
        return $this;
    }

    /**
     * Initializes a new payment link object.
     */
    public function build(): PaymentLink
    {
        return CoreHelper::clone($this->instance);
    }
}
