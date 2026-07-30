<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\AcceptedPaymentMethods;
use Square\Models\CheckoutOptions;
use Square\Models\Money;
use Square\Models\ShippingFee;

/**
 * Builder for model CheckoutOptions
 *
 * @see CheckoutOptions
 */
class CheckoutOptionsBuilder
{
    /**
     * @var CheckoutOptions
     */
    private $instance;

    private function __construct(CheckoutOptions $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new checkout options Builder object.
     */
    public static function init(): self
    {
        return new self(new CheckoutOptions());
    }

    /**
     * Sets allow tipping field.
     */
    public function allowTipping(?bool $value): self
    {
        $this->instance->setAllowTipping($value);
        return $this;
    }

    /**
     * Unsets allow tipping field.
     */
    public function unsetAllowTipping(): self
    {
        $this->instance->unsetAllowTipping();
        return $this;
    }

    /**
     * Sets custom fields field.
     */
    public function customFields(?array $value): self
    {
        $this->instance->setCustomFields($value);
        return $this;
    }

    /**
     * Unsets custom fields field.
     */
    public function unsetCustomFields(): self
    {
        $this->instance->unsetCustomFields();
        return $this;
    }

    /**
     * Sets subscription plan id field.
     */
    public function subscriptionPlanId(?string $value): self
    {
        $this->instance->setSubscriptionPlanId($value);
        return $this;
    }

    /**
     * Unsets subscription plan id field.
     */
    public function unsetSubscriptionPlanId(): self
    {
        $this->instance->unsetSubscriptionPlanId();
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
     * Sets accepted payment methods field.
     */
    public function acceptedPaymentMethods(?AcceptedPaymentMethods $value): self
    {
        $this->instance->setAcceptedPaymentMethods($value);
        return $this;
    }

    /**
     * Sets app fee money field.
     */
    public function appFeeMoney(?Money $value): self
    {
        $this->instance->setAppFeeMoney($value);
        return $this;
    }

    /**
     * Sets shipping fee field.
     */
    public function shippingFee(?ShippingFee $value): self
    {
        $this->instance->setShippingFee($value);
        return $this;
    }

    /**
     * Initializes a new checkout options object.
     */
    public function build(): CheckoutOptions
    {
        return CoreHelper::clone($this->instance);
    }
}
