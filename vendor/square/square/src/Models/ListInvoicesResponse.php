<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Describes a `ListInvoice` response.
 */
class ListInvoicesResponse implements \JsonSerializable
{
    /**
     * @var Invoice[]|null
     */
    private $invoices;

    /**
     * @var string|null
     */
    private $cursor;

    /**
     * @var Error[]|null
     */
    private $errors;

    /**
     * Returns Invoices.
     * The invoices retrieved.
     *
     * @return Invoice[]|null
     */
    public function getInvoices(): ?array
    {
        return $this->invoices;
    }

    /**
     * Sets Invoices.
     * The invoices retrieved.
     *
     * @maps invoices
     *
     * @param Invoice[]|null $invoices
     */
    public function setInvoices(?array $invoices): void
    {
        $this->invoices = $invoices;
    }

    /**
     * Returns Cursor.
     * When a response is truncated, it includes a cursor that you can use in a
     * subsequent request to retrieve the next set of invoices. If empty, this is the final
     * response.
     * For more information, see [Pagination](https://developer.squareup.com/docs/working-with-
     * apis/pagination).
     */
    public function getCursor(): ?string
    {
        return $this->cursor;
    }

    /**
     * Sets Cursor.
     * When a response is truncated, it includes a cursor that you can use in a
     * subsequent request to retrieve the next set of invoices. If empty, this is the final
     * response.
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
        if (isset($this->invoices)) {
            $json['invoices'] = $this->invoices;
        }
        if (isset($this->cursor)) {
            $json['cursor']   = $this->cursor;
        }
        if (isset($this->errors)) {
            $json['errors']   = $this->errors;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
