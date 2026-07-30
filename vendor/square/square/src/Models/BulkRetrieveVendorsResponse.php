<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Represents an output from a call to [BulkRetrieveVendors]($e/Vendors/BulkRetrieveVendors).
 */
class BulkRetrieveVendorsResponse implements \JsonSerializable
{
    /**
     * @var Error[]|null
     */
    private $errors;

    /**
     * @var array<string,RetrieveVendorResponse>|null
     */
    private $responses;

    /**
     * Returns Errors.
     * Any errors that occurred during the request.
     *
     * @return Error[]|null
     */
    public function getErrors(): ?array
    {
        return $this->errors;
    }

    /**
     * Sets Errors.
     * Any errors that occurred during the request.
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
     * Returns Responses.
     * The set of [RetrieveVendorResponse](entity:RetrieveVendorResponse) objects encapsulating
     * successfully retrieved [Vendor](entity:Vendor)
     * objects or error responses for failed attempts. The set is represented by
     * a collection of `Vendor`-ID/`Vendor`-object or `Vendor`-ID/error-object pairs.
     *
     * @return array<string,RetrieveVendorResponse>|null
     */
    public function getResponses(): ?array
    {
        return $this->responses;
    }

    /**
     * Sets Responses.
     * The set of [RetrieveVendorResponse](entity:RetrieveVendorResponse) objects encapsulating
     * successfully retrieved [Vendor](entity:Vendor)
     * objects or error responses for failed attempts. The set is represented by
     * a collection of `Vendor`-ID/`Vendor`-object or `Vendor`-ID/error-object pairs.
     *
     * @maps responses
     *
     * @param array<string,RetrieveVendorResponse>|null $responses
     */
    public function setResponses(?array $responses): void
    {
        $this->responses = $responses;
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
            $json['errors']    = $this->errors;
        }
        if (isset($this->responses)) {
            $json['responses'] = $this->responses;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
