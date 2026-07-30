<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\Address;
use Square\Models\Card;

/**
 * Builder for model Card
 *
 * @see Card
 */
class CardBuilder
{
    /**
     * @var Card
     */
    private $instance;

    private function __construct(Card $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new card Builder object.
     */
    public static function init(): self
    {
        return new self(new Card());
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
     * Sets card brand field.
     */
    public function cardBrand(?string $value): self
    {
        $this->instance->setCardBrand($value);
        return $this;
    }

    /**
     * Sets last 4 field.
     */
    public function last4(?string $value): self
    {
        $this->instance->setLast4($value);
        return $this;
    }

    /**
     * Sets exp month field.
     */
    public function expMonth(?int $value): self
    {
        $this->instance->setExpMonth($value);
        return $this;
    }

    /**
     * Unsets exp month field.
     */
    public function unsetExpMonth(): self
    {
        $this->instance->unsetExpMonth();
        return $this;
    }

    /**
     * Sets exp year field.
     */
    public function expYear(?int $value): self
    {
        $this->instance->setExpYear($value);
        return $this;
    }

    /**
     * Unsets exp year field.
     */
    public function unsetExpYear(): self
    {
        $this->instance->unsetExpYear();
        return $this;
    }

    /**
     * Sets cardholder name field.
     */
    public function cardholderName(?string $value): self
    {
        $this->instance->setCardholderName($value);
        return $this;
    }

    /**
     * Unsets cardholder name field.
     */
    public function unsetCardholderName(): self
    {
        $this->instance->unsetCardholderName();
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
     * Sets fingerprint field.
     */
    public function fingerprint(?string $value): self
    {
        $this->instance->setFingerprint($value);
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
     * Sets merchant id field.
     */
    public function merchantId(?string $value): self
    {
        $this->instance->setMerchantId($value);
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
     * Sets enabled field.
     */
    public function enabled(?bool $value): self
    {
        $this->instance->setEnabled($value);
        return $this;
    }

    /**
     * Sets card type field.
     */
    public function cardType(?string $value): self
    {
        $this->instance->setCardType($value);
        return $this;
    }

    /**
     * Sets prepaid type field.
     */
    public function prepaidType(?string $value): self
    {
        $this->instance->setPrepaidType($value);
        return $this;
    }

    /**
     * Sets bin field.
     */
    public function bin(?string $value): self
    {
        $this->instance->setBin($value);
        return $this;
    }

    /**
     * Sets version field.
     */
    public function version(?int $value): self
    {
        $this->instance->setVersion($value);
        return $this;
    }

    /**
     * Sets card co brand field.
     */
    public function cardCoBrand(?string $value): self
    {
        $this->instance->setCardCoBrand($value);
        return $this;
    }

    /**
     * Initializes a new card object.
     */
    public function build(): Card
    {
        return CoreHelper::clone($this->instance);
    }
}
