<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Either the `order_entries` or `orders` field is set, depending on whether
 * `return_entries` is set on the [SearchOrdersRequest]($e/Orders/SearchOrders).
 */
class SearchOrdersResponse implements \JsonSerializable
{
    /**
     * @var OrderEntry[]|null
     */
    private $orderEntries;

    /**
     * @var Order[]|null
     */
    private $orders;

    /**
     * @var string|null
     */
    private $cursor;

    /**
     * @var Error[]|null
     */
    private $errors;

    /**
     * Returns Order Entries.
     * A list of [OrderEntries](entity:OrderEntry) that fit the query
     * conditions. The list is populated only if `return_entries` is set to `true` in the request.
     *
     * @return OrderEntry[]|null
     */
    public function getOrderEntries(): ?array
    {
        return $this->orderEntries;
    }

    /**
     * Sets Order Entries.
     * A list of [OrderEntries](entity:OrderEntry) that fit the query
     * conditions. The list is populated only if `return_entries` is set to `true` in the request.
     *
     * @maps order_entries
     *
     * @param OrderEntry[]|null $orderEntries
     */
    public function setOrderEntries(?array $orderEntries): void
    {
        $this->orderEntries = $orderEntries;
    }

    /**
     * Returns Orders.
     * A list of
     * [Order](entity:Order) objects that match the query conditions. The list is populated only if
     * `return_entries` is set to `false` in the request.
     *
     * @return Order[]|null
     */
    public function getOrders(): ?array
    {
        return $this->orders;
    }

    /**
     * Sets Orders.
     * A list of
     * [Order](entity:Order) objects that match the query conditions. The list is populated only if
     * `return_entries` is set to `false` in the request.
     *
     * @maps orders
     *
     * @param Order[]|null $orders
     */
    public function setOrders(?array $orders): void
    {
        $this->orders = $orders;
    }

    /**
     * Returns Cursor.
     * The pagination cursor to be used in a subsequent request. If unset,
     * this is the final response.
     * For more information, see [Pagination](https://developer.squareup.com/docs/build-basics/common-api-
     * patterns/pagination).
     */
    public function getCursor(): ?string
    {
        return $this->cursor;
    }

    /**
     * Sets Cursor.
     * The pagination cursor to be used in a subsequent request. If unset,
     * this is the final response.
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
     * [Errors](entity:Error) encountered during the search.
     *
     * @return Error[]|null
     */
    public function getErrors(): ?array
    {
        return $this->errors;
    }

    /**
     * Sets Errors.
     * [Errors](entity:Error) encountered during the search.
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
        if (isset($this->orderEntries)) {
            $json['order_entries'] = $this->orderEntries;
        }
        if (isset($this->orders)) {
            $json['orders']        = $this->orders;
        }
        if (isset($this->cursor)) {
            $json['cursor']        = $this->cursor;
        }
        if (isset($this->errors)) {
            $json['errors']        = $this->errors;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
