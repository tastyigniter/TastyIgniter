<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Describes a `SearchInvoices` request.
 */
class SearchInvoicesRequest implements \JsonSerializable
{
    /**
     * @var InvoiceQuery
     */
    private $query;

    /**
     * @var int|null
     */
    private $limit;

    /**
     * @var string|null
     */
    private $cursor;

    /**
     * @param InvoiceQuery $query
     */
    public function __construct(InvoiceQuery $query)
    {
        $this->query = $query;
    }

    /**
     * Returns Query.
     * Describes query criteria for searching invoices.
     */
    public function getQuery(): InvoiceQuery
    {
        return $this->query;
    }

    /**
     * Sets Query.
     * Describes query criteria for searching invoices.
     *
     * @required
     * @maps query
     */
    public function setQuery(InvoiceQuery $query): void
    {
        $this->query = $query;
    }

    /**
     * Returns Limit.
     * The maximum number of invoices to return (200 is the maximum `limit`).
     * If not provided, the server uses a default limit of 100 invoices.
     */
    public function getLimit(): ?int
    {
        return $this->limit;
    }

    /**
     * Sets Limit.
     * The maximum number of invoices to return (200 is the maximum `limit`).
     * If not provided, the server uses a default limit of 100 invoices.
     *
     * @maps limit
     */
    public function setLimit(?int $limit): void
    {
        $this->limit = $limit;
    }

    /**
     * Returns Cursor.
     * A pagination cursor returned by a previous call to this endpoint.
     * Provide this cursor to retrieve the next set of results for your original query.
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
     * A pagination cursor returned by a previous call to this endpoint.
     * Provide this cursor to retrieve the next set of results for your original query.
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
        $json['query']      = $this->query;
        if (isset($this->limit)) {
            $json['limit']  = $this->limit;
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
