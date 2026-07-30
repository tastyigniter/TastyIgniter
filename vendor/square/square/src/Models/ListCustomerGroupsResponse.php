<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Defines the fields that are included in the response body of
 * a request to the [ListCustomerGroups]($e/CustomerGroups/ListCustomerGroups) endpoint.
 *
 * Either `errors` or `groups` is present in a given response (never both).
 */
class ListCustomerGroupsResponse implements \JsonSerializable
{
    /**
     * @var Error[]|null
     */
    private $errors;

    /**
     * @var CustomerGroup[]|null
     */
    private $groups;

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
     * Returns Groups.
     * A list of customer groups belonging to the current seller.
     *
     * @return CustomerGroup[]|null
     */
    public function getGroups(): ?array
    {
        return $this->groups;
    }

    /**
     * Sets Groups.
     * A list of customer groups belonging to the current seller.
     *
     * @maps groups
     *
     * @param CustomerGroup[]|null $groups
     */
    public function setGroups(?array $groups): void
    {
        $this->groups = $groups;
    }

    /**
     * Returns Cursor.
     * A pagination cursor to retrieve the next set of results for your
     * original query to the endpoint. This value is present only if the request
     * succeeded and additional results are available.
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
     * A pagination cursor to retrieve the next set of results for your
     * original query to the endpoint. This value is present only if the request
     * succeeded and additional results are available.
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
            $json['errors'] = $this->errors;
        }
        if (isset($this->groups)) {
            $json['groups'] = $this->groups;
        }
        if (isset($this->cursor)) {
            $json['cursor'] = $this->cursor;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
