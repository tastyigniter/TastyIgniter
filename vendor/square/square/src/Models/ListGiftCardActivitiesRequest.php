<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Returns a list of gift card activities. You can optionally specify a filter to retrieve a
 * subset of activites.
 */
class ListGiftCardActivitiesRequest implements \JsonSerializable
{
    /**
     * @var array
     */
    private $giftCardId = [];

    /**
     * @var array
     */
    private $type = [];

    /**
     * @var array
     */
    private $locationId = [];

    /**
     * @var array
     */
    private $beginTime = [];

    /**
     * @var array
     */
    private $endTime = [];

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
    private $sortOrder = [];

    /**
     * Returns Gift Card Id.
     * If a gift card ID is provided, the endpoint returns activities related
     * to the specified gift card. Otherwise, the endpoint returns all gift card activities for
     * the seller.
     */
    public function getGiftCardId(): ?string
    {
        if (count($this->giftCardId) == 0) {
            return null;
        }
        return $this->giftCardId['value'];
    }

    /**
     * Sets Gift Card Id.
     * If a gift card ID is provided, the endpoint returns activities related
     * to the specified gift card. Otherwise, the endpoint returns all gift card activities for
     * the seller.
     *
     * @maps gift_card_id
     */
    public function setGiftCardId(?string $giftCardId): void
    {
        $this->giftCardId['value'] = $giftCardId;
    }

    /**
     * Unsets Gift Card Id.
     * If a gift card ID is provided, the endpoint returns activities related
     * to the specified gift card. Otherwise, the endpoint returns all gift card activities for
     * the seller.
     */
    public function unsetGiftCardId(): void
    {
        $this->giftCardId = [];
    }

    /**
     * Returns Type.
     * If a [type](entity:GiftCardActivityType) is provided, the endpoint returns gift card activities of
     * the specified type.
     * Otherwise, the endpoint returns all types of gift card activities.
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
     * If a [type](entity:GiftCardActivityType) is provided, the endpoint returns gift card activities of
     * the specified type.
     * Otherwise, the endpoint returns all types of gift card activities.
     *
     * @maps type
     */
    public function setType(?string $type): void
    {
        $this->type['value'] = $type;
    }

    /**
     * Unsets Type.
     * If a [type](entity:GiftCardActivityType) is provided, the endpoint returns gift card activities of
     * the specified type.
     * Otherwise, the endpoint returns all types of gift card activities.
     */
    public function unsetType(): void
    {
        $this->type = [];
    }

    /**
     * Returns Location Id.
     * If a location ID is provided, the endpoint returns gift card activities for the specified location.
     * Otherwise, the endpoint returns gift card activities for all locations.
     */
    public function getLocationId(): ?string
    {
        if (count($this->locationId) == 0) {
            return null;
        }
        return $this->locationId['value'];
    }

    /**
     * Sets Location Id.
     * If a location ID is provided, the endpoint returns gift card activities for the specified location.
     * Otherwise, the endpoint returns gift card activities for all locations.
     *
     * @maps location_id
     */
    public function setLocationId(?string $locationId): void
    {
        $this->locationId['value'] = $locationId;
    }

    /**
     * Unsets Location Id.
     * If a location ID is provided, the endpoint returns gift card activities for the specified location.
     * Otherwise, the endpoint returns gift card activities for all locations.
     */
    public function unsetLocationId(): void
    {
        $this->locationId = [];
    }

    /**
     * Returns Begin Time.
     * The timestamp for the beginning of the reporting period, in RFC 3339 format.
     * This start time is inclusive. The default value is the current time minus one year.
     */
    public function getBeginTime(): ?string
    {
        if (count($this->beginTime) == 0) {
            return null;
        }
        return $this->beginTime['value'];
    }

    /**
     * Sets Begin Time.
     * The timestamp for the beginning of the reporting period, in RFC 3339 format.
     * This start time is inclusive. The default value is the current time minus one year.
     *
     * @maps begin_time
     */
    public function setBeginTime(?string $beginTime): void
    {
        $this->beginTime['value'] = $beginTime;
    }

    /**
     * Unsets Begin Time.
     * The timestamp for the beginning of the reporting period, in RFC 3339 format.
     * This start time is inclusive. The default value is the current time minus one year.
     */
    public function unsetBeginTime(): void
    {
        $this->beginTime = [];
    }

    /**
     * Returns End Time.
     * The timestamp for the end of the reporting period, in RFC 3339 format.
     * This end time is inclusive. The default value is the current time.
     */
    public function getEndTime(): ?string
    {
        if (count($this->endTime) == 0) {
            return null;
        }
        return $this->endTime['value'];
    }

    /**
     * Sets End Time.
     * The timestamp for the end of the reporting period, in RFC 3339 format.
     * This end time is inclusive. The default value is the current time.
     *
     * @maps end_time
     */
    public function setEndTime(?string $endTime): void
    {
        $this->endTime['value'] = $endTime;
    }

    /**
     * Unsets End Time.
     * The timestamp for the end of the reporting period, in RFC 3339 format.
     * This end time is inclusive. The default value is the current time.
     */
    public function unsetEndTime(): void
    {
        $this->endTime = [];
    }

    /**
     * Returns Limit.
     * If a limit is provided, the endpoint returns the specified number
     * of results (or fewer) per page. The maximum value is 100. The default value is 50.
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
     * If a limit is provided, the endpoint returns the specified number
     * of results (or fewer) per page. The maximum value is 100. The default value is 50.
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
     * If a limit is provided, the endpoint returns the specified number
     * of results (or fewer) per page. The maximum value is 100. The default value is 50.
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
     * Returns Sort Order.
     * The order in which the endpoint returns the activities, based on `created_at`.
     * - `ASC` - Oldest to newest.
     * - `DESC` - Newest to oldest (default).
     */
    public function getSortOrder(): ?string
    {
        if (count($this->sortOrder) == 0) {
            return null;
        }
        return $this->sortOrder['value'];
    }

    /**
     * Sets Sort Order.
     * The order in which the endpoint returns the activities, based on `created_at`.
     * - `ASC` - Oldest to newest.
     * - `DESC` - Newest to oldest (default).
     *
     * @maps sort_order
     */
    public function setSortOrder(?string $sortOrder): void
    {
        $this->sortOrder['value'] = $sortOrder;
    }

    /**
     * Unsets Sort Order.
     * The order in which the endpoint returns the activities, based on `created_at`.
     * - `ASC` - Oldest to newest.
     * - `DESC` - Newest to oldest (default).
     */
    public function unsetSortOrder(): void
    {
        $this->sortOrder = [];
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
        if (!empty($this->giftCardId)) {
            $json['gift_card_id'] = $this->giftCardId['value'];
        }
        if (!empty($this->type)) {
            $json['type']         = $this->type['value'];
        }
        if (!empty($this->locationId)) {
            $json['location_id']  = $this->locationId['value'];
        }
        if (!empty($this->beginTime)) {
            $json['begin_time']   = $this->beginTime['value'];
        }
        if (!empty($this->endTime)) {
            $json['end_time']     = $this->endTime['value'];
        }
        if (!empty($this->limit)) {
            $json['limit']        = $this->limit['value'];
        }
        if (!empty($this->cursor)) {
            $json['cursor']       = $this->cursor['value'];
        }
        if (!empty($this->sortOrder)) {
            $json['sort_order']   = $this->sortOrder['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
