<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Lists all [Subscription]($m/WebhookSubscription)s owned by your application.
 */
class ListWebhookSubscriptionsRequest implements \JsonSerializable
{
    /**
     * @var array
     */
    private $cursor = [];

    /**
     * @var array
     */
    private $includeDisabled = [];

    /**
     * @var string|null
     */
    private $sortOrder;

    /**
     * @var array
     */
    private $limit = [];

    /**
     * Returns Cursor.
     * A pagination cursor returned by a previous call to this endpoint.
     * Provide this to retrieve the next set of results for your original query.
     *
     * For more information, see [Pagination](https://developer.squareup.com/docs/basics/api101/pagination).
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
     * For more information, see [Pagination](https://developer.squareup.com/docs/basics/api101/pagination).
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
     * For more information, see [Pagination](https://developer.squareup.com/docs/basics/api101/pagination).
     */
    public function unsetCursor(): void
    {
        $this->cursor = [];
    }

    /**
     * Returns Include Disabled.
     * Includes disabled [Subscription](entity:WebhookSubscription)s.
     * By default, all enabled [Subscription](entity:WebhookSubscription)s are returned.
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
     * Includes disabled [Subscription](entity:WebhookSubscription)s.
     * By default, all enabled [Subscription](entity:WebhookSubscription)s are returned.
     *
     * @maps include_disabled
     */
    public function setIncludeDisabled(?bool $includeDisabled): void
    {
        $this->includeDisabled['value'] = $includeDisabled;
    }

    /**
     * Unsets Include Disabled.
     * Includes disabled [Subscription](entity:WebhookSubscription)s.
     * By default, all enabled [Subscription](entity:WebhookSubscription)s are returned.
     */
    public function unsetIncludeDisabled(): void
    {
        $this->includeDisabled = [];
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
     * Returns Limit.
     * The maximum number of results to be returned in a single page.
     * It is possible to receive fewer results than the specified limit on a given page.
     * The default value of 100 is also the maximum allowed value.
     *
     * Default: 100
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
     * The maximum number of results to be returned in a single page.
     * It is possible to receive fewer results than the specified limit on a given page.
     * The default value of 100 is also the maximum allowed value.
     *
     * Default: 100
     *
     * @maps limit
     */
    public function setLimit(?int $limit): void
    {
        $this->limit['value'] = $limit;
    }

    /**
     * Unsets Limit.
     * The maximum number of results to be returned in a single page.
     * It is possible to receive fewer results than the specified limit on a given page.
     * The default value of 100 is also the maximum allowed value.
     *
     * Default: 100
     */
    public function unsetLimit(): void
    {
        $this->limit = [];
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
        if (!empty($this->includeDisabled)) {
            $json['include_disabled'] = $this->includeDisabled['value'];
        }
        if (isset($this->sortOrder)) {
            $json['sort_order']       = $this->sortOrder;
        }
        if (!empty($this->limit)) {
            $json['limit']            = $this->limit['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
