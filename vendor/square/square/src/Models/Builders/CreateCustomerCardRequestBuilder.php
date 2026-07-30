<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\Address;
use Square\Models\CreateCustomerCardRequest;

/**
 * Builder for model CreateCustomerCardRequest
 *
 * @see CreateCustomerCardRequest
 */
class CreateCustomerCardRequestBuilder
{
    /**
     * @var CreateCustomerCardRequest
     */
    private $instance;

    private function __construct(CreateCustomerCardRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new create customer card request Builder object.
     */
    public static function init(string $cardNonce): self
    {
        return new self(new CreateCustomerCardRequest($cardNonce));
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
     * Sets cardholder name field.
     */
    public function cardholderName(?string $value): self
    {
        $this->instance->setCardholderName($value);
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
     * Initializes a new create customer card request object.
     */
    public function build(): CreateCustomerCardRequest
    {
        return CoreHelper::clone($this->instance);
    }
}
