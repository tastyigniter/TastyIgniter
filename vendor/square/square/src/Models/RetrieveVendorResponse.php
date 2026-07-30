<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Represents an output from a call to [RetrieveVendor]($e/Vendors/RetrieveVendor).
 */
class RetrieveVendorResponse implements \JsonSerializable
{
    /**
     * @var Error[]|null
     */
    private $errors;

    /**
     * @var Vendor|null
     */
    private $vendor;

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
     * Returns Vendor.
     * Represents a supplier to a seller.
     */
    public function getVendor(): ?Vendor
    {
        return $this->vendor;
    }

    /**
     * Sets Vendor.
     * Represents a supplier to a seller.
     *
     * @maps vendor
     */
    public function setVendor(?Vendor $vendor): void
    {
        $this->vendor = $vendor;
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
            $json['errors'] = $this->errors;
        }
        if (isset($this->vendor)) {
            $json['vendor'] = $this->vendor;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
