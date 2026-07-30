<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Retrieves details for a specific Card. Accessible via
 * HTTP requests at GET https://connect.squareup.com/v2/cards
 */
class ListCardsRequest implements \JsonSerializable
{
    /**
     * @var array
     */
    private $cursor = [];

    /**
     * @var array
     */
    private $customerId = [];

    /**
     * @var array
     */
    private $includeDisabled = [];

    /**
     * @var array
     */
    private $referenceId = [];

    /**
     * @var string|null
     */
    private $sortOrder;

    /**
     * Returns Cursor.
     * A pagination cursor returned by a previous call to this endpoint.
     * Provide this to retrieve the next set of results for your original query.
     *
     * See [Pagination](https://developer.squareup.com/docs/build-basics/common-api-patterns/pagination)
     * for more information.
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
     * Provide this to retrieve the next set of results for your original query.
     *
     * See [Pagination](https://developer.squareup.com/docs/build-basics/common-api-patterns/pagination)
     * for more information.
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
     * Provide this to retrieve the next set of results for your original query.
     *
     * See [Pagination](https://developer.squareup.com/docs/build-basics/common-api-patterns/pagination)
     * for more information.
     */
    public function unsetCursor(): void
    {
        $this->cursor = [];
    }

    /**
     * Returns Customer Id.
     * Limit results to cards associated with the customer supplied.
     * By default, all cards owned by the merchant are returned.
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
     * Limit results to cards associated with the customer supplied.
     * By default, all cards owned by the merchant are returned.
     *
     * @maps customer_id
     */
    public function setCustomerId(?string $customerId): void
    {
        $this->customerId['value'] = $customerId;
    }

    /**
     * Unsets Customer Id.
     * Limit results to cards associated with the customer supplied.
     * By default, all cards owned by the merchant are returned.
     */
    public function unsetCustomerId(): void
    {
        $this->customerId = [];
    }

    /**
     * Returns Include Disabled.
     * Includes disabled cards.
     * By default, all enabled cards owned by the merchant are returned.
     */
    public function getIncludeDisabled(): ?bool
    {
        if (count($this->includeDisabled) == 0) {
            return null;
        }
        return $this->includeDisabled['value'];
    }

    /**
     * Sets Include Disabled.
     * Includes disabled cards.
     * By default, all enabled cards owned by the merchant are returned.
     *
     * @maps include_disabled
     */
    public function setIncludeDisabled(?bool $includeDisabled): void
    {
        $this->includeDisabled['value'] = $includeDisabled;
    }

    /**
     * Unsets Include Disabled.
     * Includes disabled cards.
     * By default, all enabled cards owned by the merchant are returned.
     */
    public function unsetIncludeDisabled(): void
    {
        $this->includeDisabled = [];
    }

    /**
     * Returns Reference Id.
     * Limit results to cards associated with the reference_id supplied.
     */
    public function getReferenceId(): ?string
    {
        if (count($this->referenceId) == 0) {
            return null;
        }
        return $this->referenceId['value'];
    }

    /**
     * Sets Reference Id.
     * Limit results to cards associated with the reference_id supplied.
     *
     * @maps reference_id
     */
    public function setReferenceId(?string $referenceId): void
    {
        $this->referenceId['value'] = $referenceId;
    }

    /**
     * Unsets Reference Id.
     * Limit results to cards associated with the reference_id supplied.
     */
    public function unsetReferenceId(): void
    {
        $this->referenceId = [];
    }

    /**
     * Returns Sort Order.
     * The order (e.g., chronological or alphabetical) in which results from a request are returned.
     */
    public function getSortOrder(): ?string
    {
        return $this->sortOrder;
    }

    /**
     * Sets Sort Order.
     * The order (e.g., chronological or alphabetical) in which results from a request are returned.
     *
     * @maps sort_order
     */
    public function setSortOrder(?string $sortOrder): void
    {
        $this->sortOrder = $sortOrder;
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
        if (!empty($this->cursor)) {
            $json['cursor']           = $this->cursor['value'];
        }
        if (!empty($this->customerId)) {
            $json['customer_id']      = $this->customerId['value'];
        }
        if (!empty($this->includeDisabled)) {
            $json['include_disabled'] = $this->includeDisabled['value'];
        }
        if (!empty($this->referenceId)) {
            $json['reference_id']     = $this->referenceId['value'];
        }
        if (isset($this->sortOrder)) {
            $json['sort_order']       = $this->sortOrder;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
