<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\Employee;

/**
 * Builder for model Employee
 *
 * @see Employee
 */
class EmployeeBuilder
{
    /**
     * @var Employee
     */
    private $instance;

    private function __construct(Employee $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new employee Builder object.
     */
    public static function init(): self
    {
        return new self(new Employee());
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
     * Sets first name field.
     */
    public function firstName(?string $value): self
    {
        $this->instance->setFirstName($value);
        return $this;
    }

    /**
     * Unsets first name field.
     */
    public function unsetFirstName(): self
    {
        $this->instance->unsetFirstName();
        return $this;
    }

    /**
     * Sets last name field.
     */
    public function lastName(?string $value): self
    {
        $this->instance->setLastName($value);
        return $this;
    }

    /**
     * Unsets last name field.
     */
    public function unsetLastName(): self
    {
        $this->instance->unsetLastName();
        return $this;
    }

    /**
     * Sets email field.
     */
    public function email(?string $value): self
    {
        $this->instance->setEmail($value);
        return $this;
    }

    /**
     * Unsets email field.
     */
    public function unsetEmail(): self
    {
        $this->instance->unsetEmail();
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
     * Sets location ids field.
     */
    public function locationIds(?array $value): self
    {
        $this->instance->setLocationIds($value);
        return $this;
    }

    /**
     * Unsets location ids field.
     */
    public function unsetLocationIds(): self
    {
        $this->instance->unsetLocationIds();
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
     * Sets is owner field.
     */
    public function isOwner(?bool $value): self
    {
        $this->instance->setIsOwner($value);
        return $this;
    }

    /**
     * Unsets is owner field.
     */
    public function unsetIsOwner(): self
    {
        $this->instance->unsetIsOwner();
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
     * Initializes a new employee object.
     */
    public function build(): Employee
    {
        return CoreHelper::clone($this->instance);
    }
}
