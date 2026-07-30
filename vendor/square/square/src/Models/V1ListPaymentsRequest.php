<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

class V1ListPaymentsRequest implements \JsonSerializable
{
    /**
     * @var string|null
     */
    private $order;

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
    private $batchToken = [];

    /**
     * @var array
     */
    private $includePartial = [];

    /**
     * Returns Order.
     * The order (e.g., chronological or alphabetical) in which results from a request are returned.
     */
    public function getOrder(): ?string
    {
        return $this->order;
    }

    /**
     * Sets Order.
     * The order (e.g., chronological or alphabetical) in which results from a request are returned.
     *
     * @maps order
     */
    public function setOrder(?string $order): void
    {
        $this->order = $order;
    }

    /**
     * Returns Begin Time.
     * The beginning of the requested reporting period, in ISO 8601 format. If this value is before January
     * 1, 2013 (2013-01-01T00:00:00Z), this endpoint returns an error. Default value: The current time
     * minus one year.
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
     * The beginning of the requested reporting period, in ISO 8601 format. If this value is before January
     * 1, 2013 (2013-01-01T00:00:00Z), this endpoint returns an error. Default value: The current time
     * minus one year.
     *
     * @maps begin_time
     */
    public function setBeginTime(?string $beginTime): void
    {
        $this->beginTime['value'] = $beginTime;
    }

    /**
     * Unsets Begin Time.
     * The beginning of the requested reporting period, in ISO 8601 format. If this value is before January
     * 1, 2013 (2013-01-01T00:00:00Z), this endpoint returns an error. Default value: The current time
     * minus one year.
     */
    public function unsetBeginTime(): void
    {
        $this->beginTime = [];
    }

    /**
     * Returns End Time.
     * The end of the requested reporting period, in ISO 8601 format. If this value is more than one year
     * greater than begin_time, this endpoint returns an error. Default value: The current time.
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
     * The end of the requested reporting period, in ISO 8601 format. If this value is more than one year
     * greater than begin_time, this endpoint returns an error. Default value: The current time.
     *
     * @maps end_time
     */
    public function setEndTime(?string $endTime): void
    {
        $this->endTime['value'] = $endTime;
    }

    /**
     * Unsets End Time.
     * The end of the requested reporting period, in ISO 8601 format. If this value is more than one year
     * greater than begin_time, this endpoint returns an error. Default value: The current time.
     */
    public function unsetEndTime(): void
    {
        $this->endTime = [];
    }

    /**
     * Returns Limit.
     * The maximum number of payments to return in a single response. This value cannot exceed 200.
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
     * The maximum number of payments to return in a single response. This value cannot exceed 200.
     *
     * @maps limit
     */
    public function setLimit(?int $limit): void
    {
        $this->limit['value'] = $limit;
    }

    /**
     * Unsets Limit.
     * The maximum number of payments to return in a single response. This value cannot exceed 200.
     */
    public function unsetLimit(): void
    {
        $this->limit = [];
    }

    /**
     * Returns Batch Token.
     * A pagination cursor to retrieve the next set of results for your
     * original query to the endpoint.
     */
    public function getBatchToken(): ?string
    {
        if (count($this->batchToken) == 0) {
            return null;
        }
        return $this->batchToken['value'];
    }

    /**
     * Sets Batch Token.
     * A pagination cursor to retrieve the next set of results for your
     * original query to the endpoint.
     *
     * @maps batch_token
     */
    public function setBatchToken(?string $batchToken): void
    {
        $this->batchToken['value'] = $batchToken;
    }

    /**
     * Unsets Batch Token.
     * A pagination cursor to retrieve the next set of results for your
     * original query to the endpoint.
     */
    public function unsetBatchToken(): void
    {
        $this->batchToken = [];
    }

    /**
     * Returns Include Partial.
     * Indicates whether or not to include partial payments in the response. Partial payments will have the
     * tenders collected so far, but the itemizations will be empty until the payment is completed.
     */
    public function getIncludePartial(): ?bool
    {
        if (count($this->includePartial) == 0) {
            return null;
        }
        return $this->includePartial['value'];
    }

    /**
     * Sets Include Partial.
     * Indicates whether or not to include partial payments in the response. Partial payments will have the
     * tenders collected so far, but the itemizations will be empty until the payment is completed.
     *
     * @maps include_partial
     */
    public function setIncludePartial(?bool $includePartial): void
    {
        $this->includePartial['value'] = $includePartial;
    }

    /**
     * Unsets Include Partial.
     * Indicates whether or not to include partial payments in the response. Partial payments will have the
     * tenders collected so far, but the itemizations will be empty until the payment is completed.
     */
    public function unsetIncludePartial(): void
    {
        $this->includePartial = [];
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
        if (isset($this->order)) {
            $json['order']           = $this->order;
        }
        if (!empty($this->beginTime)) {
            $json['begin_time']      = $this->beginTime['value'];
        }
        if (!empty($this->endTime)) {
            $json['end_time']        = $this->endTime['value'];
        }
        if (!empty($this->limit)) {
            $json['limit']           = $this->limit['value'];
        }
        if (!empty($this->batchToken)) {
            $json['batch_token']     = $this->batchToken['value'];
        }
        if (!empty($this->includePartial)) {
            $json['include_partial'] = $this->includePartial['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
