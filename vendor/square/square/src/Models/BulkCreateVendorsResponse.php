<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Represents an output from a call to [BulkCreateVendors]($e/Vendors/BulkCreateVendors).
 */
class BulkCreateVendorsResponse implements \JsonSerializable
{
    /**
     * @var Error[]|null
     */
    private $errors;

    /**
     * @var array<string,CreateVendorResponse>|null
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
     * A set of [CreateVendorResponse](entity:CreateVendorResponse) objects encapsulating successfully
     * created [Vendor](entity:Vendor)
     * objects or error responses for failed attempts. The set is represented by
     * a collection of idempotency-key/`Vendor`-object or idempotency-key/error-object pairs. The
     * idempotency keys correspond to those specified
     * in the input.
     *
     * @return array<string,CreateVendorResponse>|null
     */
    public function getResponses(): ?array
    {
        return $this->responses;
    }

    /**
     * Sets Responses.
     * A set of [CreateVendorResponse](entity:CreateVendorResponse) objects encapsulating successfully
     * created [Vendor](entity:Vendor)
     * objects or error responses for failed attempts. The set is represented by
     * a collection of idempotency-key/`Vendor`-object or idempotency-key/error-object pairs. The
     * idempotency keys correspond to those specified
     * in the input.
     *
     * @maps responses
     *
     * @param array<string,CreateVendorResponse>|null $responses
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
