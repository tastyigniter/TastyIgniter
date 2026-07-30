<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Defines output parameters in a response from the
 * [SearchSubscriptions]($e/Subscriptions/SearchSubscriptions) endpoint.
 */
class SearchSubscriptionsResponse implements \JsonSerializable
{
    /**
     * @var Error[]|null
     */
    private $errors;

    /**
     * @var Subscription[]|null
     */
    private $subscriptions;

    /**
     * @var string|null
     */
    private $cursor;

    /**
     * Returns Errors.
     * Errors encountered during the request.
     *
     * @return Error[]|null
     */
    public function getErrors(): ?array
    {
        return $this->errors;
    }

    /**
     * Sets Errors.
     * Errors encountered during the request.
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
     * Returns Subscriptions.
     * The subscriptions matching the specified query expressions.
     *
     * @return Subscription[]|null
     */
    public function getSubscriptions(): ?array
    {
        return $this->subscriptions;
    }

    /**
     * Sets Subscriptions.
     * The subscriptions matching the specified query expressions.
     *
     * @maps subscriptions
     *
     * @param Subscription[]|null $subscriptions
     */
    public function setSubscriptions(?array $subscriptions): void
    {
        $this->subscriptions = $subscriptions;
    }

    /**
     * Returns Cursor.
     * When the total number of resulting subscription exceeds the limit of a paged response,
     * the response includes a cursor for you to use in a subsequent request to fetch the next set of
     * results.
     * If the cursor is unset, the response contains the last page of the results.
     *
     * For more information, see [Pagination](https://developer.squareup.com/docs/working-with-
     * apis/pagination).
     */
    public function getCursor(): ?string
    {
        return $this->cursor;
    }

    /**
     * Sets Cursor.
     * When the total number of resulting subscription exceeds the limit of a paged response,
     * the response includes a cursor for you to use in a subsequent request to fetch the next set of
     * results.
     * If the cursor is unset, the response contains the last page of the results.
     *
     * For more information, see [Pagination](https://developer.squareup.com/docs/working-with-
     * apis/pagination).
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
            $json['errors']        = $this->errors;
        }
        if (isset($this->subscriptions)) {
            $json['subscriptions'] = $this->subscriptions;
        }
        if (isset($this->cursor)) {
            $json['cursor']        = $this->cursor;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
