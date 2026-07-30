<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Describes a request to list refunds using
 * [ListPaymentRefunds]($e/Refunds/ListPaymentRefunds).
 *
 * The maximum results per page is 100.
 */
class ListPaymentRefundsRequest implements \JsonSerializable
{
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
    private $sortOrder = [];

    /**
     * @var array
     */
    private $cursor = [];

    /**
     * @var array
     */
    private $locationId = [];

    /**
     * @var array
     */
    private $status = [];

    /**
     * @var array
     */
    private $sourceType = [];

    /**
     * @var array
     */
    private $limit = [];

    /**
     * Returns Begin Time.
     * Indicates the start of the time range to retrieve each PaymentRefund` for, in RFC 3339
     * format.  The range is determined using the `created_at` field for each `PaymentRefund`.
     *
     * Default: The current time minus one year.
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
     * Indicates the start of the time range to retrieve each PaymentRefund` for, in RFC 3339
     * format.  The range is determined using the `created_at` field for each `PaymentRefund`.
     *
     * Default: The current time minus one year.
     *
     * @maps begin_time
     */
    public function setBeginTime(?string $beginTime): void
    {
        $this->beginTime['value'] = $beginTime;
    }

    /**
     * Unsets Begin Time.
     * Indicates the start of the time range to retrieve each PaymentRefund` for, in RFC 3339
     * format.  The range is determined using the `created_at` field for each `PaymentRefund`.
     *
     * Default: The current time minus one year.
     */
    public function unsetBeginTime(): void
    {
        $this->beginTime = [];
    }

    /**
     * Returns End Time.
     * Indicates the end of the time range to retrieve each `PaymentRefund` for, in RFC 3339
     * format.  The range is determined using the `created_at` field for each `PaymentRefund`.
     *
     * Default: The current time.
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
     * Indicates the end of the time range to retrieve each `PaymentRefund` for, in RFC 3339
     * format.  The range is determined using the `created_at` field for each `PaymentRefund`.
     *
     * Default: The current time.
     *
     * @maps end_time
     */
    public function setEndTime(?string $endTime): void
    {
        $this->endTime['value'] = $endTime;
    }

    /**
     * Unsets End Time.
     * Indicates the end of the time range to retrieve each `PaymentRefund` for, in RFC 3339
     * format.  The range is determined using the `created_at` field for each `PaymentRefund`.
     *
     * Default: The current time.
     */
    public function unsetEndTime(): void
    {
        $this->endTime = [];
    }

    /**
     * Returns Sort Order.
     * The order in which results are listed by `PaymentRefund.created_at`:
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
     * The order in which results are listed by `PaymentRefund.created_at`:
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
     * The order in which results are listed by `PaymentRefund.created_at`:
     * - `ASC` - Oldest to newest.
     * - `DESC` - Newest to oldest (default).
     */
    public function unsetSortOrder(): void
    {
        $this->sortOrder = [];
    }

    /**
     * Returns Cursor.
     * A pagination cursor returned by a previous call to this endpoint.
     * Provide this cursor to retrieve the next set of results for the original query.
     *
     * For more information, see [Pagination](https://developer.squareup.com/docs/build-basics/common-api-
     * patterns/pagination).
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
     *
     * For more information, see [Pagination](https://developer.squareup.com/docs/build-basics/common-api-
     * patterns/pagination).
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
     *
     * For more information, see [Pagination](https://developer.squareup.com/docs/build-basics/common-api-
     * patterns/pagination).
     */
    public function unsetCursor(): void
    {
        $this->cursor = [];
    }

    /**
     * Returns Location Id.
     * Limit results to the location supplied. By default, results are returned
     * for all locations associated with the seller.
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
     * Limit results to the location supplied. By default, results are returned
     * for all locations associated with the seller.
     *
     * @maps location_id
     */
    public function setLocationId(?string $locationId): void
    {
        $this->locationId['value'] = $locationId;
    }

    /**
     * Unsets Location Id.
     * Limit results to the location supplied. By default, results are returned
     * for all locations associated with the seller.
     */
    public function unsetLocationId(): void
    {
        $this->locationId = [];
    }

    /**
     * Returns Status.
     * If provided, only refunds with the given status are returned.
     * For a list of refund status values, see [PaymentRefund](entity:PaymentRefund).
     *
     * Default: If omitted, refunds are returned regardless of their status.
     */
    public function getStatus(): ?string
    {
        if (count($this->status) == 0) {
            return null;
        }
        return $this->status['value'];
    }

    /**
     * Sets Status.
     * If provided, only refunds with the given status are returned.
     * For a list of refund status values, see [PaymentRefund](entity:PaymentRefund).
     *
     * Default: If omitted, refunds are returned regardless of their status.
     *
     * @maps status
     */
    public function setStatus(?string $status): void
    {
        $this->status['value'] = $status;
    }

    /**
     * Unsets Status.
     * If provided, only refunds with the given status are returned.
     * For a list of refund status values, see [PaymentRefund](entity:PaymentRefund).
     *
     * Default: If omitted, refunds are returned regardless of their status.
     */
    public function unsetStatus(): void
    {
        $this->status = [];
    }

    /**
     * Returns Source Type.
     * If provided, only returns refunds whose payments have the indicated source type.
     * Current values include `CARD`, `BANK_ACCOUNT`, `WALLET`, `CASH`, and `EXTERNAL`.
     * For information about these payment source types, see
     * [Take Payments](https://developer.squareup.com/docs/payments-api/take-payments).
     *
     * Default: If omitted, refunds are returned regardless of the source type.
     */
    public function getSourceType(): ?string
    {
        if (count($this->sourceType) == 0) {
            return null;
        }
        return $this->sourceType['value'];
    }

    /**
     * Sets Source Type.
     * If provided, only returns refunds whose payments have the indicated source type.
     * Current values include `CARD`, `BANK_ACCOUNT`, `WALLET`, `CASH`, and `EXTERNAL`.
     * For information about these payment source types, see
     * [Take Payments](https://developer.squareup.com/docs/payments-api/take-payments).
     *
     * Default: If omitted, refunds are returned regardless of the source type.
     *
     * @maps source_type
     */
    public function setSourceType(?string $sourceType): void
    {
        $this->sourceType['value'] = $sourceType;
    }

    /**
     * Unsets Source Type.
     * If provided, only returns refunds whose payments have the indicated source type.
     * Current values include `CARD`, `BANK_ACCOUNT`, `WALLET`, `CASH`, and `EXTERNAL`.
     * For information about these payment source types, see
     * [Take Payments](https://developer.squareup.com/docs/payments-api/take-payments).
     *
     * Default: If omitted, refunds are returned regardless of the source type.
     */
    public function unsetSourceType(): void
    {
        $this->sourceType = [];
    }

    /**
     * Returns Limit.
     * The maximum number of results to be returned in a single page.
     *
     * It is possible to receive fewer results than the specified limit on a given page.
     *
     * If the supplied value is greater than 100, no more than 100 results are returned.
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
     *
     * It is possible to receive fewer results than the specified limit on a given page.
     *
     * If the supplied value is greater than 100, no more than 100 results are returned.
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
     *
     * It is possible to receive fewer results than the specified limit on a given page.
     *
     * If the supplied value is greater than 100, no more than 100 results are returned.
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
        if (!empty($this->beginTime)) {
            $json['begin_time']  = $this->beginTime['value'];
        }
        if (!empty($this->endTime)) {
            $json['end_time']    = $this->endTime['value'];
        }
        if (!empty($this->sortOrder)) {
            $json['sort_order']  = $this->sortOrder['value'];
        }
        if (!empty($this->cursor)) {
            $json['cursor']      = $this->cursor['value'];
        }
        if (!empty($this->locationId)) {
            $json['location_id'] = $this->locationId['value'];
        }
        if (!empty($this->status)) {
            $json['status']      = $this->status['value'];
        }
        if (!empty($this->sourceType)) {
            $json['source_type'] = $this->sourceType['value'];
        }
        if (!empty($this->limit)) {
            $json['limit']       = $this->limit['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
