<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * A request to list gift cards. You can optionally specify a filter to retrieve a subset of
 * gift cards.
 */
class ListGiftCardsRequest implements \JsonSerializable
{
    /**
     * @var array
     */
    private $type = [];

    /**
     * @var array
     */
    private $state = [];

    /**
     * @var array
     */
    private $limit = [];

    /**
     * @var array
     */
    private $cursor = [];

    /**
     * @var array
     */
    private $customerId = [];

    /**
     * Returns Type.
     * If a [type](entity:GiftCardType) is provided, the endpoint returns gift cards of the specified type.
     * Otherwise, the endpoint returns gift cards of all types.
     */
    public function getType(): ?string
    {
        if (count($this->type) == 0) {
            return null;
        }
        return $this->type['value'];
    }

    /**
     * Sets Type.
     * If a [type](entity:GiftCardType) is provided, the endpoint returns gift cards of the specified type.
     * Otherwise, the endpoint returns gift cards of all types.
     *
     * @maps type
     */
    public function setType(?string $type): void
    {
        $this->type['value'] = $type;
    }

    /**
     * Unsets Type.
     * If a [type](entity:GiftCardType) is provided, the endpoint returns gift cards of the specified type.
     * Otherwise, the endpoint returns gift cards of all types.
     */
    public function unsetType(): void
    {
        $this->type = [];
    }

    /**
     * Returns State.
     * If a [state](entity:GiftCardStatus) is provided, the endpoint returns the gift cards in the
     * specified state.
     * Otherwise, the endpoint returns the gift cards of all states.
     */
    public function getState(): ?string
    {
        if (count($this->state) == 0) {
            return null;
        }
        return $this->state['value'];
    }

    /**
     * Sets State.
     * If a [state](entity:GiftCardStatus) is provided, the endpoint returns the gift cards in the
     * specified state.
     * Otherwise, the endpoint returns the gift cards of all states.
     *
     * @maps state
     */
    public function setState(?string $state): void
    {
        $this->state['value'] = $state;
    }

    /**
     * Unsets State.
     * If a [state](entity:GiftCardStatus) is provided, the endpoint returns the gift cards in the
     * specified state.
     * Otherwise, the endpoint returns the gift cards of all states.
     */
    public function unsetState(): void
    {
        $this->state = [];
    }

    /**
     * Returns Limit.
     * If a limit is provided, the endpoint returns only the specified number of results per page.
     * The maximum value is 50. The default value is 30.
     * For more information, see [Pagination](https://developer.squareup.com/docs/working-with-
     * apis/pagination).
     */
    public function getLimit(): ?int
    {
        if (count($this->limit) == 0) {
            return null;
        }
        return $this->limit['value'];
    }

    /**
     * Sets Limit.
     * If a limit is provided, the endpoint returns only the specified number of results per page.
     * The maximum value is 50. The default value is 30.
     * For more information, see [Pagination](https://developer.squareup.com/docs/working-with-
     * apis/pagination).
     *
     * @maps limit
     */
    public function setLimit(?int $limit): void
    {
        $this->limit['value'] = $limit;
    }

    /**
     * Unsets Limit.
     * If a limit is provided, the endpoint returns only the specified number of results per page.
     * The maximum value is 50. The default value is 30.
     * For more information, see [Pagination](https://developer.squareup.com/docs/working-with-
     * apis/pagination).
     */
    public function unsetLimit(): void
    {
        $this->limit = [];
    }

    /**
     * Returns Cursor.
     * A pagination cursor returned by a previous call to this endpoint.
     * Provide this cursor to retrieve the next set of results for the original query.
     * If a cursor is not provided, the endpoint returns the first page of the results.
     * For more information, see [Pagination](https://developer.squareup.com/docs/working-with-
     * apis/pagination).
     */
    public function getCursor(): ?string
    {
        if (count($this->cursor) == 0) {
            return null;
        }
        return $this->cursor['value'];
    }

    /**
     * Sets Cursor.
     * A pagination cursor returned by a previous call to this endpoint.
     * Provide this cursor to retrieve the next set of results for the original query.
     * If a cursor is not provided, the endpoint returns the first page of the results.
     * For more information, see [Pagination](https://developer.squareup.com/docs/working-with-
     * apis/pagination).
     *
     * @maps cursor
     */
    public function setCursor(?string $cursor): void
    {
        $this->cursor['value'] = $cursor;
    }

    /**
     * Unsets Cursor.
     * A pagination cursor returned by a previous call to this endpoint.
     * Provide this cursor to retrieve the next set of results for the original query.
     * If a cursor is not provided, the endpoint returns the first page of the results.
     * For more information, see [Pagination](https://developer.squareup.com/docs/working-with-
     * apis/pagination).
     */
    public function unsetCursor(): void
    {
        $this->cursor = [];
    }

    /**
     * Returns Customer Id.
     * If a customer ID is provided, the endpoint returns only the gift cards linked to the specified
     * customer.
     */
    public function getCustomerId(): ?string
    {
        if (count($this->customerId) == 0) {
            return null;
        }
        return $this->customerId['value'];
    }

    /**
     * Sets Customer Id.
     * If a customer ID is provided, the endpoint returns only the gift cards linked to the specified
     * customer.
     *
     * @maps customer_id
     */
    public function setCustomerId(?string $customerId): void
    {
        $this->customerId['value'] = $customerId;
    }

    /**
     * Unsets Customer Id.
     * If a customer ID is provided, the endpoint returns only the gift cards linked to the specified
     * customer.
     */
    public function unsetCustomerId(): void
    {
        $this->customerId = [];
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
        if (!empty($this->type)) {
            $json['type']        = $this->type['value'];
        }
        if (!empty($this->state)) {
            $json['state']       = $this->state['value'];
        }
        if (!empty($this->limit)) {
            $json['limit']       = $this->limit['value'];
        }
        if (!empty($this->cursor)) {
            $json['cursor']      = $this->cursor['value'];
        }
        if (!empty($this->customerId)) {
            $json['customer_id'] = $this->customerId['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
