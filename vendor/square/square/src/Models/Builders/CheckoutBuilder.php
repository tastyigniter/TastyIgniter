<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\Address;
use Square\Models\Checkout;
use Square\Models\Order;

/**
 * Builder for model Checkout
 *
 * @see Checkout
 */
class CheckoutBuilder
{
    /**
     * @var Checkout
     */
    private $instance;

    private function __construct(Checkout $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new checkout Builder object.
     */
    public static function init(): self
    {
        return new self(new Checkout());
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
     * Sets checkout page url field.
     */
    public function checkoutPageUrl(?string $value): self
    {
        $this->instance->setCheckoutPageUrl($value);
        return $this;
    }

    /**
     * Unsets checkout page url field.
     */
    public function unsetCheckoutPageUrl(): self
    {
        $this->instance->unsetCheckoutPageUrl();
        return $this;
    }

    /**
     * Sets ask for shipping address field.
     */
    public function askForShippingAddress(?bool $value): self
    {
        $this->instance->setAskForShippingAddress($value);
        return $this;
    }

    /**
     * Unsets ask for shipping address field.
     */
    public function unsetAskForShippingAddress(): self
    {
        $this->instance->unsetAskForShippingAddress();
        return $this;
    }

    /**
     * Sets merchant support email field.
     */
    public function merchantSupportEmail(?string $value): self
    {
        $this->instance->setMerchantSupportEmail($value);
        return $this;
    }

    /**
     * Unsets merchant support email field.
     */
    public function unsetMerchantSupportEmail(): self
    {
        $this->instance->unsetMerchantSupportEmail();
        return $this;
    }

    /**
     * Sets pre populate buyer email field.
     */
    public function prePopulateBuyerEmail(?string $value): self
    {
        $this->instance->setPrePopulateBuyerEmail($value);
        return $this;
    }

    /**
     * Unsets pre populate buyer email field.
     */
    public function unsetPrePopulateBuyerEmail(): self
    {
        $this->instance->unsetPrePopulateBuyerEmail();
        return $this;
    }

    /**
     * Sets pre populate shipping address field.
     */
    public function prePopulateShippingAddress(?Address $value): self
    {
        $this->instance->setPrePopulateShippingAddress($value);
        return $this;
    }

    /**
     * Sets redirect url field.
     */
    public function redirectUrl(?string $value): self
    {
        $this->instance->setRedirectUrl($value);
        return $this;
    }

    /**
     * Unsets redirect url field.
     */
    public function unsetRedirectUrl(): self
    {
        $this->instance->unsetRedirectUrl();
        return $this;
    }

    /**
     * Sets order field.
     */
    public function order(?Order $value): self
    {
        $this->instance->setOrder($value);
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
     * Sets additional recipients field.
     */
    public function additionalRecipients(?array $value): self
    {
        $this->instance->setAdditionalRecipients($value);
        return $this;
    }

    /**
     * Unsets additional recipients field.
     */
    public function unsetAdditionalRecipients(): self
    {
        $this->instance->unsetAdditionalRecipients();
        return $this;
    }

    /**
     * Initializes a new checkout object.
     */
    public function build(): Checkout
    {
        return CoreHelper::clone($this->instance);
    }
}
