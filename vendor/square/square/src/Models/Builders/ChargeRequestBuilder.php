<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\Address;
use Square\Models\ChargeRequest;
use Square\Models\Money;

/**
 * Builder for model ChargeRequest
 *
 * @see ChargeRequest
 */
class ChargeRequestBuilder
{
    /**
     * @var ChargeRequest
     */
    private $instance;

    private function __construct(ChargeRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new charge request Builder object.
     */
    public static function init(string $idempotencyKey, Money $amountMoney): self
    {
        return new self(new ChargeRequest($idempotencyKey, $amountMoney));
    }

    /**
     * Sets card nonce field.
     */
    public function cardNonce(?string $value): self
    {
        $this->instance->setCardNonce($value);
        return $this;
    }

    /**
     * Unsets card nonce field.
     */
    public function unsetCardNonce(): self
    {
        $this->instance->unsetCardNonce();
        return $this;
    }

    /**
     * Sets customer card id field.
     */
    public function customerCardId(?string $value): self
    {
        $this->instance->setCustomerCardId($value);
        return $this;
    }

    /**
     * Unsets customer card id field.
     */
    public function unsetCustomerCardId(): self
    {
        $this->instance->unsetCustomerCardId();
        return $this;
    }

    /**
     * Sets delay capture field.
     */
    public function delayCapture(?bool $value): self
    {
        $this->instance->setDelayCapture($value);
        return $this;
    }

    /**
     * Unsets delay capture field.
     */
    public function unsetDelayCapture(): self
    {
        $this->instance->unsetDelayCapture();
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
     * Sets note field.
     */
    public function note(?string $value): self
    {
        $this->instance->setNote($value);
        return $this;
    }

    /**
     * Unsets note field.
     */
    public function unsetNote(): self
    {
        $this->instance->unsetNote();
        return $this;
    }

    /**
     * Sets customer id field.
     */
    public function customerId(?string $value): self
    {
        $this->instance->setCustomerId($value);
        return $this;
    }

    /**
     * Unsets customer id field.
     */
    public function unsetCustomerId(): self
    {
        $this->instance->unsetCustomerId();
        return $this;
    }

    /**
     * Sets billing address field.
     */
    public function billingAddress(?Address $value): self
    {
        $this->instance->setBillingAddress($value);
        return $this;
    }

    /**
     * Sets shipping address field.
     */
    public function shippingAddress(?Address $value): self
    {
        $this->instance->setShippingAddress($value);
        return $this;
    }

    /**
     * Sets buyer email address field.
     */
    public function buyerEmailAddress(?string $value): self
    {
        $this->instance->setBuyerEmailAddress($value);
        return $this;
    }

    /**
     * Unsets buyer email address field.
     */
    public function unsetBuyerEmailAddress(): self
    {
        $this->instance->unsetBuyerEmailAddress();
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
     * Sets verification token field.
     */
    public function verificationToken(?string $value): self
    {
        $this->instance->setVerificationToken($value);
        return $this;
    }

    /**
     * Unsets verification token field.
     */
    public function unsetVerificationToken(): self
    {
        $this->instance->unsetVerificationToken();
        return $this;
    }

    /**
     * Initializes a new charge request object.
     */
    public function build(): ChargeRequest
    {
        return CoreHelper::clone($this->instance);
    }
}
