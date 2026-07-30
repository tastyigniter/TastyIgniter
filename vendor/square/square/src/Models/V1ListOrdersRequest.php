<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

class V1ListOrdersRequest implements \JsonSerializable
{
    /**
     * @var string|null
     */
    private $order;

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
