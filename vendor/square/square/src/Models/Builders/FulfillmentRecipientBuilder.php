<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\Address;
use Square\Models\FulfillmentRecipient;

/**
 * Builder for model FulfillmentRecipient
 *
 * @see FulfillmentRecipient
 */
class FulfillmentRecipientBuilder
{
    /**
     * @var FulfillmentRecipient
     */
    private $instance;

    private function __construct(FulfillmentRecipient $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new fulfillment recipient Builder object.
     */
    public static function init(): self
    {
        return new self(new FulfillmentRecipient());
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
     * Sets display name field.
     */
    public function displayName(?string $value): self
    {
        $this->instance->setDisplayName($value);
        return $this;
    }

    /**
     * Unsets display name field.
     */
    public function unsetDisplayName(): self
    {
        $this->instance->unsetDisplayName();
        return $this;
    }

    /**
     * Sets email address field.
     */
    public function emailAddress(?string $value): self
    {
        $this->instance->setEmailAddress($value);
        return $this;
    }

    /**
     * Unsets email address field.
     */
    public function unsetEmailAddress(): self
    {
        $this->instance->unsetEmailAddress();
        return $this;
    }

    /**
     * Sets phone number field.
     */
    public function phoneNumber(?string $value): self
    {
        $this->instance->setPhoneNumber($value);
        return $this;
    }

    /**
     * Unsets phone number field.
     */
    public function unsetPhoneNumber(): self
    {
        $this->instance->unsetPhoneNumber();
        return $this;
    }

    /**
     * Sets address field.
     */
    public function address(?Address $value): self
    {
        $this->instance->setAddress($value);
        return $this;
    }

    /**
     * Initializes a new fulfillment recipient object.
     */
    public function build(): FulfillmentRecipient
    {
        return CoreHelper::clone($this->instance);
    }
}
