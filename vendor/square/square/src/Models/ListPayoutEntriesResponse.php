<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * The response to retrieve payout records entries.
 */
class ListPayoutEntriesResponse implements \JsonSerializable
{
    /**
     * @var PayoutEntry[]|null
     */
    private $payoutEntries;

    /**
     * @var string|null
     */
    private $cursor;

    /**
     * @var Error[]|null
     */
    private $errors;

    /**
     * Returns Payout Entries.
     * The requested list of payout entries, ordered with the given or default sort order.
     *
     * @return PayoutEntry[]|null
     */
    public function getPayoutEntries(): ?array
    {
        return $this->payoutEntries;
    }

    /**
     * Sets Payout Entries.
     * The requested list of payout entries, ordered with the given or default sort order.
     *
     * @maps payout_entries
     *
     * @param PayoutEntry[]|null $payoutEntries
     */
    public function setPayoutEntries(?array $payoutEntries): void
    {
        $this->payoutEntries = $payoutEntries;
    }

    /**
     * Returns Cursor.
     * The pagination cursor to be used in a subsequent request. If empty, this is the final response.
     * For more information, see [Pagination](https://developer.squareup.com/docs/build-basics/common-api-
     * patterns/pagination).
     */
    public function getCursor(): ?string
    {
        return $this->cursor;
    }

    /**
     * Sets Cursor.
     * The pagination cursor to be used in a subsequent request. If empty, this is the final response.
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
     * Returns Errors.
     * Information about errors encountered during the request.
     *
     * @return Error[]|null
     */
    public function getErrors(): ?array
    {
        return $this->errors;
    }

    /**
     * Sets Errors.
     * Information about errors encountered during the request.
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
        if (isset($this->payoutEntries)) {
            $json['payout_entries'] = $this->payoutEntries;
        }
        if (isset($this->cursor)) {
            $json['cursor']         = $this->cursor;
        }
        if (isset($this->errors)) {
            $json['errors']         = $this->errors;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
