<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\Address;

/**
 * Builder for model Address
 *
 * @see Address
 */
class AddressBuilder
{
    /**
     * @var Address
     */
    private $instance;

    private function __construct(Address $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new address Builder object.
     */
    public static function init(): self
    {
        return new self(new Address());
    }

    /**
     * Sets address line 1 field.
     */
    public function addressLine1(?string $value): self
    {
        $this->instance->setAddressLine1($value);
        return $this;
    }

    /**
     * Unsets address line 1 field.
     */
    public function unsetAddressLine1(): self
    {
        $this->instance->unsetAddressLine1();
        return $this;
    }

    /**
     * Sets address line 2 field.
     */
    public function addressLine2(?string $value): self
    {
        $this->instance->setAddressLine2($value);
        return $this;
    }

    /**
     * Unsets address line 2 field.
     */
    public function unsetAddressLine2(): self
    {
        $this->instance->unsetAddressLine2();
        return $this;
    }

    /**
     * Sets address line 3 field.
     */
    public function addressLine3(?string $value): self
    {
        $this->instance->setAddressLine3($value);
        return $this;
    }

    /**
     * Unsets address line 3 field.
     */
    public function unsetAddressLine3(): self
    {
        $this->instance->unsetAddressLine3();
        return $this;
    }

    /**
     * Sets locality field.
     */
    public function locality(?string $value): self
    {
        $this->instance->setLocality($value);
        return $this;
    }

    /**
     * Unsets locality field.
     */
    public function unsetLocality(): self
    {
        $this->instance->unsetLocality();
        return $this;
    }

    /**
     * Sets sublocality field.
     */
    public function sublocality(?string $value): self
    {
        $this->instance->setSublocality($value);
        return $this;
    }

    /**
     * Unsets sublocality field.
     */
    public function unsetSublocality(): self
    {
        $this->instance->unsetSublocality();
        return $this;
    }

    /**
     * Sets sublocality 2 field.
     */
    public function sublocality2(?string $value): self
    {
        $this->instance->setSublocality2($value);
        return $this;
    }

    /**
     * Unsets sublocality 2 field.
     */
    public function unsetSublocality2(): self
    {
        $this->instance->unsetSublocality2();
        return $this;
    }

    /**
     * Sets sublocality 3 field.
     */
    public function sublocality3(?string $value): self
    {
        $this->instance->setSublocality3($value);
        return $this;
    }

    /**
     * Unsets sublocality 3 field.
     */
    public function unsetSublocality3(): self
    {
        $this->instance->unsetSublocality3();
        return $this;
    }

    /**
     * Sets administrative district level 1 field.
     */
    public function administrativeDistrictLevel1(?string $value): self
    {
        $this->instance->setAdministrativeDistrictLevel1($value);
        return $this;
    }

    /**
     * Unsets administrative district level 1 field.
     */
    public function unsetAdministrativeDistrictLevel1(): self
    {
        $this->instance->unsetAdministrativeDistrictLevel1();
        return $this;
    }

    /**
     * Sets administrative district level 2 field.
     */
    public function administrativeDistrictLevel2(?string $value): self
    {
        $this->instance->setAdministrativeDistrictLevel2($value);
        return $this;
    }

    /**
     * Unsets administrative district level 2 field.
     */
    public function unsetAdministrativeDistrictLevel2(): self
    {
        $this->instance->unsetAdministrativeDistrictLevel2();
        return $this;
    }

    /**
     * Sets administrative district level 3 field.
     */
    public function administrativeDistrictLevel3(?string $value): self
    {
        $this->instance->setAdministrativeDistrictLevel3($value);
        return $this;
    }

    /**
     * Unsets administrative district level 3 field.
     */
    public function unsetAdministrativeDistrictLevel3(): self
    {
        $this->instance->unsetAdministrativeDistrictLevel3();
        return $this;
    }

    /**
     * Sets postal code field.
     */
    public function postalCode(?string $value): self
    {
        $this->instance->setPostalCode($value);
        return $this;
    }

    /**
     * Unsets postal code field.
     */
    public function unsetPostalCode(): self
    {
        $this->instance->unsetPostalCode();
        return $this;
    }

    /**
     * Sets country field.
     */
    public function country(?string $value): self
    {
        $this->instance->setCountry($value);
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
     * Initializes a new address object.
     */
    public function build(): Address
    {
        return CoreHelper::clone($this->instance);
    }
}
