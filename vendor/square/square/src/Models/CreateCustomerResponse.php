<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Defines the fields that are included in the response body of
 * a request to the `CreateCustomer` endpoint.
 *
 * Either `errors` or `customer` is present in a given response (never both).
 */
class CreateCustomerResponse implements \JsonSerializable
{
    /**
     * @var Error[]|null
     */
    private $errors;

    /**
     * @var Customer|null
     */
    private $customer;

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
     * Returns Customer.
     * Represents a Square customer profile in the Customer Directory of a Square seller.
     */
    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }

    /**
     * Sets Customer.
     * Represents a Square customer profile in the Customer Directory of a Square seller.
     *
     * @maps customer
     */
    public function setCustomer(?Customer $customer): void
    {
        $this->customer = $customer;
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
            $json['errors']   = $this->errors;
        }
        if (isset($this->customer)) {
            $json['customer'] = $this->customer;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
