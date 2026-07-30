<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\Address;
use Square\Models\CreateCheckoutRequest;
use Square\Models\CreateOrderRequest;

/**
 * Builder for model CreateCheckoutRequest
 *
 * @see CreateCheckoutRequest
 */
class CreateCheckoutRequestBuilder
{
    /**
     * @var CreateCheckoutRequest
     */
    private $instance;

    private function __construct(CreateCheckoutRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new create checkout request Builder object.
     */
    public static function init(string $idempotencyKey, CreateOrderRequest $order): self
    {
        return new self(new CreateCheckoutRequest($idempotencyKey, $order));
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
     * Sets merchant support email field.
     */
    public function merchantSupportEmail(?string $value): self
    {
        $this->instance->setMerchantSupportEmail($value);
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
     * Sets additional recipients field.
     */
    public function additionalRecipients(?array $value): self
    {
        $this->instance->setAdditionalRecipients($value);
        return $this;
    }

    /**
     * Sets note field.
     */
    public function note(?string $value): self
    {
        $this->instance->setNote($value);
        return $this;
    }

    /**
     * Initializes a new create checkout request object.
     */
    public function build(): CreateCheckoutRequest
    {
        return CoreHelper::clone($this->instance);
    }
}
