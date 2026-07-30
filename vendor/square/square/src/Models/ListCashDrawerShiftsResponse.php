<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

class ListCashDrawerShiftsResponse implements \JsonSerializable
{
    /**
     * @var CashDrawerShiftSummary[]|null
     */
    private $items;

    /**
     * @var string|null
     */
    private $cursor;

    /**
     * @var Error[]|null
     */
    private $errors;

    /**
     * Returns Items.
     * A collection of CashDrawerShiftSummary objects for shifts that match
     * the query.
     *
     * @return CashDrawerShiftSummary[]|null
     */
    public function getItems(): ?array
    {
        return $this->items;
    }

    /**
     * Sets Items.
     * A collection of CashDrawerShiftSummary objects for shifts that match
     * the query.
     *
     * @maps items
     *
     * @param CashDrawerShiftSummary[]|null $items
     */
    public function setItems(?array $items): void
    {
        $this->items = $items;
    }

    /**
     * Returns Cursor.
     * Opaque cursor for fetching the next page of results. Cursor is not
     * present in the last page of results.
     */
    public function getCursor(): ?string
    {
        return $this->cursor;
    }

    /**
     * Sets Cursor.
     * Opaque cursor for fetching the next page of results. Cursor is not
     * present in the last page of results.
     *
     * @maps cursor
     */
    public function setCursor(?string $cursor): void
    {
        $this->cursor = $cursor;
    }

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
        if (isset($this->items)) {
            $json['items']  = $this->items;
        }
        if (isset($this->cursor)) {
            $json['cursor'] = $this->cursor;
        }
        if (isset($this->errors)) {
            $json['errors'] = $this->errors;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
