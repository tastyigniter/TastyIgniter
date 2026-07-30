<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Defines the fields that are included in the response body of
 * a request to the `ListCustomers` endpoint.
 *
 * Either `errors` or `customers` is present in a given response (never both).
 */
class ListCustomersResponse implements \JsonSerializable
{
    /**
     * @var Error[]|null
     */
    private $errors;

    /**
     * @var Customer[]|null
     */
    private $customers;

    /**
     * @var string|null
     */
    private $cursor;

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
     * Returns Customers.
     * The customer profiles associated with the Square account or an empty object (`{}`) if none are found.
     *
     * @return Customer[]|null
     */
    public function getCustomers(): ?array
    {
        return $this->customers;
    }

    /**
     * Sets Customers.
     * The customer profiles associated with the Square account or an empty object (`{}`) if none are found.
     *
     * @maps customers
     *
     * @param Customer[]|null $customers
     */
    public function setCustomers(?array $customers): void
    {
        $this->customers = $customers;
    }

    /**
     * Returns Cursor.
     * A pagination cursor to retrieve the next set of results for the
     * original query. A cursor is only present if the request succeeded and additional results
     * are available.
     *
     * For more information, see [Pagination](https://developer.squareup.com/docs/build-basics/common-api-
     * patterns/pagination).
     */
    public function getCursor(): ?string
    {
        return $this->cursor;
    }

    /**
     * Sets Cursor.
     * A pagination cursor to retrieve the next set of results for the
     * original query. A cursor is only present if the request succeeded and additional results
     * are available.
     *
     * For more information, see [Pagination](https://developer.squareup.com/docs/build-basics/common-api-
     * patterns/pagination).
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
            $json['errors']    = $this->errors;
        }
        if (isset($this->customers)) {
            $json['customers'] = $this->customers;
        }
        if (isset($this->cursor)) {
            $json['cursor']    = $this->cursor;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
