<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * A type-specific filter used in a [custom attribute filter]($m/CustomerCustomAttributeFilter) to
 * search based on the value
 * of a customer-related [custom attribute]($m/CustomAttribute).
 */
class CustomerCustomAttributeFilterValue implements \JsonSerializable
{
    /**
     * @var CustomerTextFilter|null
     */
    private $email;

    /**
     * @var CustomerTextFilter|null
     */
    private $phone;

    /**
     * @var CustomerTextFilter|null
     */
    private $text;

    /**
     * @var FilterValue|null
     */
    private $selection;

    /**
     * @var TimeRange|null
     */
    private $date;

    /**
     * @var FloatNumberRange|null
     */
    private $number;

    /**
     * @var array
     */
    private $boolean = [];

    /**
     * @var CustomerAddressFilter|null
     */
    private $address;

    /**
     * Returns Email.
     * A filter to select customers based on exact or fuzzy matching of
     * customer attributes against a specified query. Depending on the customer attributes,
     * the filter can be case-sensitive. This filter can be exact or fuzzy, but it cannot be both.
     */
    public function getEmail(): ?CustomerTextFilter
    {
        return $this->email;
    }

    /**
     * Sets Email.
     * A filter to select customers based on exact or fuzzy matching of
     * customer attributes against a specified query. Depending on the customer attributes,
     * the filter can be case-sensitive. This filter can be exact or fuzzy, but it cannot be both.
     *
     * @maps email
     */
    public function setEmail(?CustomerTextFilter $email): void
    {
        $this->email = $email;
    }

    /**
     * Returns Phone.
     * A filter to select customers based on exact or fuzzy matching of
     * customer attributes against a specified query. Depending on the customer attributes,
     * the filter can be case-sensitive. This filter can be exact or fuzzy, but it cannot be both.
     */
    public function getPhone(): ?CustomerTextFilter
    {
        return $this->phone;
    }

    /**
     * Sets Phone.
     * A filter to select customers based on exact or fuzzy matching of
     * customer attributes against a specified query. Depending on the customer attributes,
     * the filter can be case-sensitive. This filter can be exact or fuzzy, but it cannot be both.
     *
     * @maps phone
     */
    public function setPhone(?CustomerTextFilter $phone): void
    {
        $this->phone = $phone;
    }

    /**
     * Returns Text.
     * A filter to select customers based on exact or fuzzy matching of
     * customer attributes against a specified query. Depending on the customer attributes,
     * the filter can be case-sensitive. This filter can be exact or fuzzy, but it cannot be both.
     */
    public function getText(): ?CustomerTextFilter
    {
        return $this->text;
    }

    /**
     * Sets Text.
     * A filter to select customers based on exact or fuzzy matching of
     * customer attributes against a specified query. Depending on the customer attributes,
     * the filter can be case-sensitive. This filter can be exact or fuzzy, but it cannot be both.
     *
     * @maps text
     */
    public function setText(?CustomerTextFilter $text): void
    {
        $this->text = $text;
    }

    /**
     * Returns Selection.
     * A filter to select resources based on an exact field value. For any given
     * value, the value can only be in one property. Depending on the field, either
     * all properties can be set or only a subset will be available.
     *
     * Refer to the documentation of the field.
     */
    public function getSelection(): ?FilterValue
    {
        return $this->selection;
    }

    /**
     * Sets Selection.
     * A filter to select resources based on an exact field value. For any given
     * value, the value can only be in one property. Depending on the field, either
     * all properties can be set or only a subset will be available.
     *
     * Refer to the documentation of the field.
     *
     * @maps selection
     */
    public function setSelection(?FilterValue $selection): void
    {
        $this->selection = $selection;
    }

    /**
     * Returns Date.
     * Represents a generic time range. The start and end values are
     * represented in RFC 3339 format. Time ranges are customized to be
     * inclusive or exclusive based on the needs of a particular endpoint.
     * Refer to the relevant endpoint-specific documentation to determine
     * how time ranges are handled.
     */
    public function getDate(): ?TimeRange
    {
        return $this->date;
    }

    /**
     * Sets Date.
     * Represents a generic time range. The start and end values are
     * represented in RFC 3339 format. Time ranges are customized to be
     * inclusive or exclusive based on the needs of a particular endpoint.
     * Refer to the relevant endpoint-specific documentation to determine
     * how time ranges are handled.
     *
     * @maps date
     */
    public function setDate(?TimeRange $date): void
    {
        $this->date = $date;
    }

    /**
     * Returns Number.
     * Specifies a decimal number range.
     */
    public function getNumber(): ?FloatNumberRange
    {
        return $this->number;
    }

    /**
     * Sets Number.
     * Specifies a decimal number range.
     *
     * @maps number
     */
    public function setNumber(?FloatNumberRange $number): void
    {
        $this->number = $number;
    }

    /**
     * Returns Boolean.
     * A filter for a query based on the value of a `Boolean`-type custom attribute.
     */
    public function getBoolean(): ?bool
    {
        if (count($this->boolean) == 0) {
            return null;
        }
        return $this->boolean['value'];
    }

    /**
     * Sets Boolean.
     * A filter for a query based on the value of a `Boolean`-type custom attribute.
     *
     * @maps boolean
     */
    public function setBoolean(?bool $boolean): void
    {
        $this->boolean['value'] = $boolean;
    }

    /**
     * Unsets Boolean.
     * A filter for a query based on the value of a `Boolean`-type custom attribute.
     */
    public function unsetBoolean(): void
    {
        $this->boolean = [];
    }

    /**
     * Returns Address.
     * The customer address filter. This filter is used in a
     * [CustomerCustomAttributeFilterValue]($m/CustomerCustomAttributeFilterValue) filter when
     * searching by an `Address`-type custom attribute.
     */
    public function getAddress(): ?CustomerAddressFilter
    {
        return $this->address;
    }

    /**
     * Sets Address.
     * The customer address filter. This filter is used in a
     * [CustomerCustomAttributeFilterValue]($m/CustomerCustomAttributeFilterValue) filter when
     * searching by an `Address`-type custom attribute.
     *
     * @maps address
     */
    public function setAddress(?CustomerAddressFilter $address): void
    {
        $this->address = $address;
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
        if (isset($this->email)) {
            $json['email']     = $this->email;
        }
        if (isset($this->phone)) {
            $json['phone']     = $this->phone;
        }
        if (isset($this->text)) {
            $json['text']      = $this->text;
        }
        if (isset($this->selection)) {
            $json['selection'] = $this->selection;
        }
        if (isset($this->date)) {
            $json['date']      = $this->date;
        }
        if (isset($this->number)) {
            $json['number']    = $this->number;
        }
        if (!empty($this->boolean)) {
            $json['boolean']   = $this->boolean['value'];
        }
        if (isset($this->address)) {
            $json['address']   = $this->address;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
