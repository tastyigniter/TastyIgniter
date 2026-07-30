<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Represents a postal address in a country.
 * For more information, see [Working with Addresses](https://developer.squareup.com/docs/build-
 * basics/working-with-addresses).
 */
class Address implements \JsonSerializable
{
    /**
     * @var array
     */
    private $addressLine1 = [];

    /**
     * @var array
     */
    private $addressLine2 = [];

    /**
     * @var array
     */
    private $addressLine3 = [];

    /**
     * @var array
     */
    private $locality = [];

    /**
     * @var array
     */
    private $sublocality = [];

    /**
     * @var array
     */
    private $sublocality2 = [];

    /**
     * @var array
     */
    private $sublocality3 = [];

    /**
     * @var array
     */
    private $administrativeDistrictLevel1 = [];

    /**
     * @var array
     */
    private $administrativeDistrictLevel2 = [];

    /**
     * @var array
     */
    private $administrativeDistrictLevel3 = [];

    /**
     * @var array
     */
    private $postalCode = [];

    /**
     * @var string|null
     */
    private $country;

    /**
     * @var array
     */
    private $firstName = [];

    /**
     * @var array
     */
    private $lastName = [];

    /**
     * Returns Address Line 1.
     * The first line of the address.
     *
     * Fields that start with `address_line` provide the address's most specific
     * details, like street number, street name, and building name. They do *not*
     * provide less specific details like city, state/province, or country (these
     * details are provided in other fields).
     */
    public function getAddressLine1(): ?string
    {
        if (count($this->addressLine1) == 0) {
            return null;
        }
        return $this->addressLine1['value'];
    }

    /**
     * Sets Address Line 1.
     * The first line of the address.
     *
     * Fields that start with `address_line` provide the address's most specific
     * details, like street number, street name, and building name. They do *not*
     * provide less specific details like city, state/province, or country (these
     * details are provided in other fields).
     *
     * @maps address_line_1
     */
    public function setAddressLine1(?string $addressLine1): void
    {
        $this->addressLine1['value'] = $addressLine1;
    }

    /**
     * Unsets Address Line 1.
     * The first line of the address.
     *
     * Fields that start with `address_line` provide the address's most specific
     * details, like street number, street name, and building name. They do *not*
     * provide less specific details like city, state/province, or country (these
     * details are provided in other fields).
     */
    public function unsetAddressLine1(): void
    {
        $this->addressLine1 = [];
    }

    /**
     * Returns Address Line 2.
     * The second line of the address, if any.
     */
    public function getAddressLine2(): ?string
    {
        if (count($this->addressLine2) == 0) {
            return null;
        }
        return $this->addressLine2['value'];
    }

    /**
     * Sets Address Line 2.
     * The second line of the address, if any.
     *
     * @maps address_line_2
     */
    public function setAddressLine2(?string $addressLine2): void
    {
        $this->addressLine2['value'] = $addressLine2;
    }

    /**
     * Unsets Address Line 2.
     * The second line of the address, if any.
     */
    public function unsetAddressLine2(): void
    {
        $this->addressLine2 = [];
    }

    /**
     * Returns Address Line 3.
     * The third line of the address, if any.
     */
    public function getAddressLine3(): ?string
    {
        if (count($this->addressLine3) == 0) {
            return null;
        }
        return $this->addressLine3['value'];
    }

    /**
     * Sets Address Line 3.
     * The third line of the address, if any.
     *
     * @maps address_line_3
     */
    public function setAddressLine3(?string $addressLine3): void
    {
        $this->addressLine3['value'] = $addressLine3;
    }

    /**
     * Unsets Address Line 3.
     * The third line of the address, if any.
     */
    public function unsetAddressLine3(): void
    {
        $this->addressLine3 = [];
    }

    /**
     * Returns Locality.
     * The city or town of the address. For a full list of field meanings by country, see [Working with
     * Addresses](https://developer.squareup.com/docs/build-basics/working-with-addresses).
     */
    public function getLocality(): ?string
    {
        if (count($this->locality) == 0) {
            return null;
        }
        return $this->locality['value'];
    }

    /**
     * Sets Locality.
     * The city or town of the address. For a full list of field meanings by country, see [Working with
     * Addresses](https://developer.squareup.com/docs/build-basics/working-with-addresses).
     *
     * @maps locality
     */
    public function setLocality(?string $locality): void
    {
        $this->locality['value'] = $locality;
    }

    /**
     * Unsets Locality.
     * The city or town of the address. For a full list of field meanings by country, see [Working with
     * Addresses](https://developer.squareup.com/docs/build-basics/working-with-addresses).
     */
    public function unsetLocality(): void
    {
        $this->locality = [];
    }

    /**
     * Returns Sublocality.
     * A civil region within the address's `locality`, if any.
     */
    public function getSublocality(): ?string
    {
        if (count($this->sublocality) == 0) {
            return null;
        }
        return $this->sublocality['value'];
    }

    /**
     * Sets Sublocality.
     * A civil region within the address's `locality`, if any.
     *
     * @maps sublocality
     */
    public function setSublocality(?string $sublocality): void
    {
        $this->sublocality['value'] = $sublocality;
    }

    /**
     * Unsets Sublocality.
     * A civil region within the address's `locality`, if any.
     */
    public function unsetSublocality(): void
    {
        $this->sublocality = [];
    }

    /**
     * Returns Sublocality 2.
     * A civil region within the address's `sublocality`, if any.
     */
    public function getSublocality2(): ?string
    {
        if (count($this->sublocality2) == 0) {
            return null;
        }
        return $this->sublocality2['value'];
    }

    /**
     * Sets Sublocality 2.
     * A civil region within the address's `sublocality`, if any.
     *
     * @maps sublocality_2
     */
    public function setSublocality2(?string $sublocality2): void
    {
        $this->sublocality2['value'] = $sublocality2;
    }

    /**
     * Unsets Sublocality 2.
     * A civil region within the address's `sublocality`, if any.
     */
    public function unsetSublocality2(): void
    {
        $this->sublocality2 = [];
    }

    /**
     * Returns Sublocality 3.
     * A civil region within the address's `sublocality_2`, if any.
     */
    public function getSublocality3(): ?string
    {
        if (count($this->sublocality3) == 0) {
            return null;
        }
        return $this->sublocality3['value'];
    }

    /**
     * Sets Sublocality 3.
     * A civil region within the address's `sublocality_2`, if any.
     *
     * @maps sublocality_3
     */
    public function setSublocality3(?string $sublocality3): void
    {
        $this->sublocality3['value'] = $sublocality3;
    }

    /**
     * Unsets Sublocality 3.
     * A civil region within the address's `sublocality_2`, if any.
     */
    public function unsetSublocality3(): void
    {
        $this->sublocality3 = [];
    }

    /**
     * Returns Administrative District Level 1.
     * A civil entity within the address's country. In the US, this
     * is the state. For a full list of field meanings by country, see [Working with Addresses](https:
     * //developer.squareup.com/docs/build-basics/working-with-addresses).
     */
    public function getAdministrativeDistrictLevel1(): ?string
    {
        if (count($this->administrativeDistrictLevel1) == 0) {
            return null;
        }
        return $this->administrativeDistrictLevel1['value'];
    }

    /**
     * Sets Administrative District Level 1.
     * A civil entity within the address's country. In the US, this
     * is the state. For a full list of field meanings by country, see [Working with Addresses](https:
     * //developer.squareup.com/docs/build-basics/working-with-addresses).
     *
     * @maps administrative_district_level_1
     */
    public function setAdministrativeDistrictLevel1(?string $administrativeDistrictLevel1): void
    {
        $this->administrativeDistrictLevel1['value'] = $administrativeDistrictLevel1;
    }

    /**
     * Unsets Administrative District Level 1.
     * A civil entity within the address's country. In the US, this
     * is the state. For a full list of field meanings by country, see [Working with Addresses](https:
     * //developer.squareup.com/docs/build-basics/working-with-addresses).
     */
    public function unsetAdministrativeDistrictLevel1(): void
    {
        $this->administrativeDistrictLevel1 = [];
    }

    /**
     * Returns Administrative District Level 2.
     * A civil entity within the address's `administrative_district_level_1`.
     * In the US, this is the county.
     */
    public function getAdministrativeDistrictLevel2(): ?string
    {
        if (count($this->administrativeDistrictLevel2) == 0) {
            return null;
        }
        return $this->administrativeDistrictLevel2['value'];
    }

    /**
     * Sets Administrative District Level 2.
     * A civil entity within the address's `administrative_district_level_1`.
     * In the US, this is the county.
     *
     * @maps administrative_district_level_2
     */
    public function setAdministrativeDistrictLevel2(?string $administrativeDistrictLevel2): void
    {
        $this->administrativeDistrictLevel2['value'] = $administrativeDistrictLevel2;
    }

    /**
     * Unsets Administrative District Level 2.
     * A civil entity within the address's `administrative_district_level_1`.
     * In the US, this is the county.
     */
    public function unsetAdministrativeDistrictLevel2(): void
    {
        $this->administrativeDistrictLevel2 = [];
    }

    /**
     * Returns Administrative District Level 3.
     * A civil entity within the address's `administrative_district_level_2`,
     * if any.
     */
    public function getAdministrativeDistrictLevel3(): ?string
    {
        if (count($this->administrativeDistrictLevel3) == 0) {
            return null;
        }
        return $this->administrativeDistrictLevel3['value'];
    }

    /**
     * Sets Administrative District Level 3.
     * A civil entity within the address's `administrative_district_level_2`,
     * if any.
     *
     * @maps administrative_district_level_3
     */
    public function setAdministrativeDistrictLevel3(?string $administrativeDistrictLevel3): void
    {
        $this->administrativeDistrictLevel3['value'] = $administrativeDistrictLevel3;
    }

    /**
     * Unsets Administrative District Level 3.
     * A civil entity within the address's `administrative_district_level_2`,
     * if any.
     */
    public function unsetAdministrativeDistrictLevel3(): void
    {
        $this->administrativeDistrictLevel3 = [];
    }

    /**
     * Returns Postal Code.
     * The address's postal code. For a full list of field meanings by country, see [Working with
     * Addresses](https://developer.squareup.com/docs/build-basics/working-with-addresses).
     */
    public function getPostalCode(): ?string
    {
        if (count($this->postalCode) == 0) {
            return null;
        }
        return $this->postalCode['value'];
    }

    /**
     * Sets Postal Code.
     * The address's postal code. For a full list of field meanings by country, see [Working with
     * Addresses](https://developer.squareup.com/docs/build-basics/working-with-addresses).
     *
     * @maps postal_code
     */
    public function setPostalCode(?string $postalCode): void
    {
        $this->postalCode['value'] = $postalCode;
    }

    /**
     * Unsets Postal Code.
     * The address's postal code. For a full list of field meanings by country, see [Working with
     * Addresses](https://developer.squareup.com/docs/build-basics/working-with-addresses).
     */
    public function unsetPostalCode(): void
    {
        $this->postalCode = [];
    }

    /**
     * Returns Country.
     * Indicates the country associated with another entity, such as a business.
     * Values are in [ISO 3166-1-alpha-2 format](http://www.iso.org/iso/home/standards/country_codes.htm).
     */
    public function getCountry(): ?string
    {
        return $this->country;
    }

    /**
     * Sets Country.
     * Indicates the country associated with another entity, such as a business.
     * Values are in [ISO 3166-1-alpha-2 format](http://www.iso.org/iso/home/standards/country_codes.htm).
     *
     * @maps country
     */
    public function setCountry(?string $country): void
    {
        $this->country = $country;
    }

    /**
     * Returns First Name.
     * Optional first name when it's representing recipient.
     */
    public function getFirstName(): ?string
    {
        if (count($this->firstName) == 0) {
            return null;
        }
        return $this->firstName['value'];
    }

    /**
     * Sets First Name.
     * Optional first name when it's representing recipient.
     *
     * @maps first_name
     */
    public function setFirstName(?string $firstName): void
    {
        $this->firstName['value'] = $firstName;
    }

    /**
     * Unsets First Name.
     * Optional first name when it's representing recipient.
     */
    public function unsetFirstName(): void
    {
        $this->firstName = [];
    }

    /**
     * Returns Last Name.
     * Optional last name when it's representing recipient.
     */
    public function getLastName(): ?string
    {
        if (count($this->lastName) == 0) {
            return null;
        }
        return $this->lastName['value'];
    }

    /**
     * Sets Last Name.
     * Optional last name when it's representing recipient.
     *
     * @maps last_name
     */
    public function setLastName(?string $lastName): void
    {
        $this->lastName['value'] = $lastName;
    }

    /**
     * Unsets Last Name.
     * Optional last name when it's representing recipient.
     */
    public function unsetLastName(): void
    {
        $this->lastName = [];
    }

    /**
     * Encode this object to JSON
     *
     * @param bool $asArrayWhenEmpty Whether to serialize this model as an array whenever no fields
     *        are set. (default: false)
     *
     * @return array|stdClass
     */
    #[\ReturnTypeWillChange] // @phan-suppress-current-line PhanUndeclaredClassAttribute for (php < 8.1)
    public function jsonSerialize(bool $asArrayWhenEmpty = false)
    {
        $json = [];
        if (!empty($this->addressLine1)) {
            $json['address_line_1']                  = $this->addressLine1['value'];
        }
        if (!empty($this->addressLine2)) {
            $json['address_line_2']                  = $this->addressLine2['value'];
        }
        if (!empty($this->addressLine3)) {
            $json['address_line_3']                  = $this->addressLine3['value'];
        }
        if (!empty($this->locality)) {
            $json['locality']                        = $this->locality['value'];
        }
        if (!empty($this->sublocality)) {
            $json['sublocality']                     = $this->sublocality['value'];
        }
        if (!empty($this->sublocality2)) {
            $json['sublocality_2']                   = $this->sublocality2['value'];
        }
        if (!empty($this->sublocality3)) {
            $json['sublocality_3']                   = $this->sublocality3['value'];
        }
        if (!empty($this->administrativeDistrictLevel1)) {
            $json['administrative_district_level_1'] = $this->administrativeDistrictLevel1['value'];
        }
        if (!empty($this->administrativeDistrictLevel2)) {
            $json['administrative_district_level_2'] = $this->administrativeDistrictLevel2['value'];
        }
        if (!empty($this->administrativeDistrictLevel3)) {
            $json['administrative_district_level_3'] = $this->administrativeDistrictLevel3['value'];
        }
        if (!empty($this->postalCode)) {
            $json['postal_code']                     = $this->postalCode['value'];
        }
        if (isset($this->country)) {
            $json['country']                         = $this->country;
        }
        if (!empty($this->firstName)) {
            $json['first_name']                      = $this->firstName['value'];
        }
        if (!empty($this->lastName)) {
            $json['last_name']                       = $this->lastName['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
