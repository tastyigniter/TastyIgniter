<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\Address;
use Square\Models\Customer;
use Square\Models\CustomerPreferences;
use Square\Models\CustomerTaxIds;

/**
 * Builder for model Customer
 *
 * @see Customer
 */
class CustomerBuilder
{
    /**
     * @var Customer
     */
    private $instance;

    private function __construct(Customer $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new customer Builder object.
     */
    public static function init(): self
    {
        return new self(new Customer());
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
     * Sets cards field.
     */
    public function cards(?array $value): self
    {
        $this->instance->setCards($value);
        return $this;
    }

    /**
     * Unsets cards field.
     */
    public function unsetCards(): self
    {
        $this->instance->unsetCards();
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
     * Unsets given name field.
     */
    public function unsetGivenName(): self
    {
        $this->instance->unsetGivenName();
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
     * Unsets family name field.
     */
    public function unsetFamilyName(): self
    {
        $this->instance->unsetFamilyName();
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
     * Unsets nickname field.
     */
    public function unsetNickname(): self
    {
        $this->instance->unsetNickname();
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
     * Unsets company name field.
     */
    public function unsetCompanyName(): self
    {
        $this->instance->unsetCompanyName();
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
     * Unsets phone number field.
     */
    public function unsetPhoneNumber(): self
    {
        $this->instance->unsetPhoneNumber();
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
     * Unsets birthday field.
     */
    public function unsetBirthday(): self
    {
        $this->instance->unsetBirthday();
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
     * Sets preferences field.
     */
    public function preferences(?CustomerPreferences $value): self
    {
        $this->instance->setPreferences($value);
        return $this;
    }

    /**
     * Sets creation source field.
     */
    public function creationSource(?string $value): self
    {
        $this->instance->setCreationSource($value);
        return $this;
    }

    /**
     * Sets group ids field.
     */
    public function groupIds(?array $value): self
    {
        $this->instance->setGroupIds($value);
        return $this;
    }

    /**
     * Unsets group ids field.
     */
    public function unsetGroupIds(): self
    {
        $this->instance->unsetGroupIds();
        return $this;
    }

    /**
     * Sets segment ids field.
     */
    public function segmentIds(?array $value): self
    {
        $this->instance->setSegmentIds($value);
        return $this;
    }

    /**
     * Unsets segment ids field.
     */
    public function unsetSegmentIds(): self
    {
        $this->instance->unsetSegmentIds();
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
     * Sets tax ids field.
     */
    public function taxIds(?CustomerTaxIds $value): self
    {
        $this->instance->setTaxIds($value);
        return $this;
    }

    /**
     * Initializes a new customer object.
     */
    public function build(): Customer
    {
        return CoreHelper::clone($this->instance);
    }
}
