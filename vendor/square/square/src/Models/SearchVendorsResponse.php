<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Represents an output from a call to [SearchVendors]($e/Vendors/SearchVendors).
 */
class SearchVendorsResponse implements \JsonSerializable
{
    /**
     * @var Error[]|null
     */
    private $errors;

    /**
     * @var Vendor[]|null
     */
    private $vendors;

    /**
     * @var string|null
     */
    private $cursor;

    /**
     * Returns Errors.
     * Errors encountered when the request fails.
     *
     * @return Error[]|null
     */
    public function getErrors(): ?array
    {
        return $this->errors;
    }

    /**
     * Sets Errors.
     * Errors encountered when the request fails.
     *
     * @maps errors
     *
     * @param Error[]|null $errors
     */
    public function setErrors(?array $errors): void
    {
        $this->errors = $errors;
    }

    /**
     * Returns Vendors.
     * The [Vendor](entity:Vendor) objects matching the specified search filter.
     *
     * @return Vendor[]|null
     */
    public function getVendors(): ?array
    {
        return $this->vendors;
    }

    /**
     * Sets Vendors.
     * The [Vendor](entity:Vendor) objects matching the specified search filter.
     *
     * @maps vendors
     *
     * @param Vendor[]|null $vendors
     */
    public function setVendors(?array $vendors): void
    {
        $this->vendors = $vendors;
    }

    /**
     * Returns Cursor.
     * The pagination cursor to be used in a subsequent request. If unset,
     * this is the final response.
     *
     * See the [Pagination](https://developer.squareup.com/docs/working-with-apis/pagination) guide for
     * more information.
     */
    public function getCursor(): ?string
    {
        return $this->cursor;
    }

    /**
     * Sets Cursor.
     * The pagination cursor to be used in a subsequent request. If unset,
     * this is the final response.
     *
     * See the [Pagination](https://developer.squareup.com/docs/working-with-apis/pagination) guide for
     * more information.
     *
     * @maps cursor
     */
    public function setCursor(?string $cursor): void
    {
        $this->cursor = $cursor;
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
        if (isset($this->errors)) {
            $json['errors']  = $this->errors;
        }
        if (isset($this->vendors)) {
            $json['vendors'] = $this->vendors;
        }
        if (isset($this->cursor)) {
            $json['cursor']  = $this->cursor;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
