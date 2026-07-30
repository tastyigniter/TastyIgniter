<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Defines the fields that are included in the response body of
 * a request to the [ListTransactions](api-endpoint:Transactions-ListTransactions) endpoint.
 *
 * One of `errors` or `transactions` is present in a given response (never both).
 */
class ListTransactionsResponse implements \JsonSerializable
{
    /**
     * @var Error[]|null
     */
    private $errors;

    /**
     * @var Transaction[]|null
     */
    private $transactions;

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
     * Returns Transactions.
     * An array of transactions that match your query.
     *
     * @return Transaction[]|null
     */
    public function getTransactions(): ?array
    {
        return $this->transactions;
    }

    /**
     * Sets Transactions.
     * An array of transactions that match your query.
     *
     * @maps transactions
     *
     * @param Transaction[]|null $transactions
     */
    public function setTransactions(?array $transactions): void
    {
        $this->transactions = $transactions;
    }

    /**
     * Returns Cursor.
     * A pagination cursor for retrieving the next set of results,
     * if any remain. Provide this value as the `cursor` parameter in a subsequent
     * request to this endpoint.
     *
     * See [Paginating results](https://developer.squareup.com/docs/working-with-apis/pagination) for more
     * information.
     */
    public function getCursor(): ?string
    {
        return $this->cursor;
    }

    /**
     * Sets Cursor.
     * A pagination cursor for retrieving the next set of results,
     * if any remain. Provide this value as the `cursor` parameter in a subsequent
     * request to this endpoint.
     *
     * See [Paginating results](https://developer.squareup.com/docs/working-with-apis/pagination) for more
     * information.
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
            $json['errors']       = $this->errors;
        }
        if (isset($this->transactions)) {
            $json['transactions'] = $this->transactions;
        }
        if (isset($this->cursor)) {
            $json['cursor']       = $this->cursor;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
