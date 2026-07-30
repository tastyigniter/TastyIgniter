<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\CheckoutOptions;
use Square\Models\CreatePaymentLinkRequest;
use Square\Models\Order;
use Square\Models\PrePopulatedData;
use Square\Models\QuickPay;

/**
 * Builder for model CreatePaymentLinkRequest
 *
 * @see CreatePaymentLinkRequest
 */
class CreatePaymentLinkRequestBuilder
{
    /**
     * @var CreatePaymentLinkRequest
     */
    private $instance;

    private function __construct(CreatePaymentLinkRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new create payment link request Builder object.
     */
    public static function init(): self
    {
        return new self(new CreatePaymentLinkRequest());
    }

    /**
     * Sets idempotency key field.
     */
    public function idempotencyKey(?string $value): self
    {
        $this->instance->setIdempotencyKey($value);
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
     * Sets quick pay field.
     */
    public function quickPay(?QuickPay $value): self
    {
        $this->instance->setQuickPay($value);
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
     * Sets payment note field.
     */
    public function paymentNote(?string $value): self
    {
        $this->instance->setPaymentNote($value);
        return $this;
    }

    /**
     * Initializes a new create payment link request object.
     */
    public function build(): CreatePaymentLinkRequest
    {
        return CoreHelper::clone($this->instance);
    }
}
