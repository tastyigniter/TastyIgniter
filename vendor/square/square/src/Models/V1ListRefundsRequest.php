<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

class V1ListRefundsRequest implements \JsonSerializable
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
     * The approximate number of refunds to return in a single response. Default: 100. Max: 200. Response
     * may contain more results than the prescribed limit when refunds are made simultaneously to multiple
     * tenders in a payment or when refunds are generated in an exchange to account for the value of
     * returned goods.
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
     * The approximate number of refunds to return in a single response. Default: 100. Max: 200. Response
     * may contain more results than the prescribed limit when refunds are made simultaneously to multiple
     * tenders in a payment or when refunds are generated in an exchange to account for the value of
     * returned goods.
     *
     * @maps limit
     */
    public function setLimit(?int $limit): void
    {
        $this->limit['value'] = $limit;
    }

    /**
     * Unsets Limit.
     * The approximate number of refunds to return in a single response. Default: 100. Max: 200. Response
     * may contain more results than the prescribed limit when refunds are made simultaneously to multiple
     * tenders in a payment or when refunds are generated in an exchange to account for the value of
     * returned goods.
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
            $json['order']       = $this->order;
        }
        if (!empty($this->beginTime)) {
            $json['begin_time']  = $this->beginTime['value'];
        }
        if (!empty($this->endTime)) {
            $json['end_time']    = $this->endTime['value'];
        }
        if (!empty($this->limit)) {
            $json['limit']       = $this->limit['value'];
        }
        if (!empty($this->batchToken)) {
            $json['batch_token'] = $this->batchToken['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
