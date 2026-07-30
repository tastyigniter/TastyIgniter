<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Defines the fields that are included in the response body of
 * a request to the [ListRefunds](api-endpoint:Transactions-ListRefunds) endpoint.
 *
 * One of `errors` or `refunds` is present in a given response (never both).
 */
class ListRefundsResponse implements \JsonSerializable
{
    /**
     * @var Error[]|null
     */
    private $errors;

    /**
     * @var Refund[]|null
     */
    private $refunds;

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
     * Returns Refunds.
     * An array of refunds that match your query.
     *
     * @return Refund[]|null
     */
    public function getRefunds(): ?array
    {
        return $this->refunds;
    }

    /**
     * Sets Refunds.
     * An array of refunds that match your query.
     *
     * @maps refunds
     *
     * @param Refund[]|null $refunds
     */
    public function setRefunds(?array $refunds): void
    {
        $this->refunds = $refunds;
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
            $json['errors']  = $this->errors;
        }
        if (isset($this->refunds)) {
            $json['refunds'] = $this->refunds;
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
