<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\Address;
use Square\Models\Vendor;

/**
 * Builder for model Vendor
 *
 * @see Vendor
 */
class VendorBuilder
{
    /**
     * @var Vendor
     */
    private $instance;

    private function __construct(Vendor $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new vendor Builder object.
     */
    public static function init(): self
    {
        return new self(new Vendor());
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
     * Sets name field.
     */
    public function name(?string $value): self
    {
        $this->instance->setName($value);
        return $this;
    }

    /**
     * Unsets name field.
     */
    public function unsetName(): self
    {
        $this->instance->unsetName();
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
     * Sets contacts field.
     */
    public function contacts(?array $value): self
    {
        $this->instance->setContacts($value);
        return $this;
    }

    /**
     * Unsets contacts field.
     */
    public function unsetContacts(): self
    {
        $this->instance->unsetContacts();
        return $this;
    }

    /**
     * Sets account number field.
     */
    public function accountNumber(?string $value): self
    {
        $this->instance->setAccountNumber($value);
        return $this;
    }

    /**
     * Unsets account number field.
     */
    public function unsetAccountNumber(): self
    {
        $this->instance->unsetAccountNumber();
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
     * Sets version field.
     */
    public function version(?int $value): self
    {
        $this->instance->setVersion($value);
        return $this;
    }

    /**
     * Sets status field.
     */
    public function status(?string $value): self
    {
        $this->instance->setStatus($value);
        return $this;
    }

    /**
     * Initializes a new vendor object.
     */
    public function build(): Vendor
    {
        return CoreHelper::clone($this->instance);
    }
}
