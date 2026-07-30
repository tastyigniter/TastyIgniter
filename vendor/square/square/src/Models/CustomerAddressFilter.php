<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * The customer address filter. This filter is used in a
 * [CustomerCustomAttributeFilterValue]($m/CustomerCustomAttributeFilterValue) filter when
 * searching by an `Address`-type custom attribute.
 */
class CustomerAddressFilter implements \JsonSerializable
{
    /**
     * @var CustomerTextFilter|null
     */
    private $postalCode;

    /**
     * @var string|null
     */
    private $country;

    /**
     * Returns Postal Code.
     * A filter to select customers based on exact or fuzzy matching of
     * customer attributes against a specified query. Depending on the customer attributes,
     * the filter can be case-sensitive. This filter can be exact or fuzzy, but it cannot be both.
     */
    public function getPostalCode(): ?CustomerTextFilter
    {
        return $this->postalCode;
    }

    /**
     * Sets Postal Code.
     * A filter to select customers based on exact or fuzzy matching of
     * customer attributes against a specified query. Depending on the customer attributes,
     * the filter can be case-sensitive. This filter can be exact or fuzzy, but it cannot be both.
     *
     * @maps postal_code
     */
    public function setPostalCode(?CustomerTextFilter $postalCode): void
    {
        $this->postalCode = $postalCode;
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
        if (isset($this->postalCode)) {
            $json['postal_code'] = $this->postalCode;
        }
        if (isset($this->country)) {
            $json['country']     = $this->country;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
