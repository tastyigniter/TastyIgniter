<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\Address;
use Square\Models\CreateCustomerRequest;
use Square\Models\CustomerTaxIds;

/**
 * Builder for model CreateCustomerRequest
 *
 * @see CreateCustomerRequest
 */
class CreateCustomerRequestBuilder
{
    /**
     * @var CreateCustomerRequest
     */
    private $instance;

    private function __construct(CreateCustomerRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new create customer request Builder object.
     */
    public static function init(): self
    {
        return new self(new CreateCustomerRequest());
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
     * Sets given name field.
     */
    public function givenName(?string $value): self
    {
        $this->instance->setGivenName($value);
        return $this;
    }

    /**
     * Sets family name field.
     */
    public function familyName(?string $value): self
    {
        $this->instance->setFamilyName($value);
        return $this;
    }

    /**
     * Sets company name field.
     */
    public function companyName(?string $value): self
    {
        $this->instance->setCompanyName($value);
        return $this;
    }

    /**
     * Sets nickname field.
     */
    public function nickname(?string $value): self
    {
        $this->instance->setNickname($value);
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
     * Sets address field.
     */
    public function address(?Address $value): self
    {
        $this->instance->setAddress($value);
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
     * Sets reference id field.
     */
    public function referenceId(?string $value): self
    {
        $this->instance->setReferenceId($value);
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
     * Sets birthday field.
     */
    public function birthday(?string $value): self
    {
        $this->instance->setBirthday($value);
        return $this;
    }

    /**
     * Sets tax ids field.
     */
    public function taxIds(?CustomerTaxIds $value): self
    {
        $this->instance->setTaxIds($value);
        return $this;
    }

    /**
     * Initializes a new create customer request object.
     */
    public function build(): CreateCustomerRequest
    {
        return CoreHelper::clone($this->instance);
    }
}
