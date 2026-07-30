<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

class ListDeviceCodesRequest implements \JsonSerializable
{
    /**
     * @var array
     */
    private $cursor = [];

    /**
     * @var array
     */
    private $locationId = [];

    /**
     * @var string|null
     */
    private $productType;

    /**
     * @var array
     */
    private $status = [];

    /**
     * Returns Cursor.
     * A pagination cursor returned by a previous call to this endpoint.
     * Provide this to retrieve the next set of results for your original query.
     *
     * See [Paginating results](https://developer.squareup.com/docs/working-with-apis/pagination) for more
     * information.
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
     * See [Paginating results](https://developer.squareup.com/docs/working-with-apis/pagination) for more
     * information.
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
     * See [Paginating results](https://developer.squareup.com/docs/working-with-apis/pagination) for more
     * information.
     */
    public function unsetCursor(): void
    {
        $this->cursor = [];
    }

    /**
     * Returns Location Id.
     * If specified, only returns DeviceCodes of the specified location.
     * Returns DeviceCodes of all locations if empty.
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
     * If specified, only returns DeviceCodes of the specified location.
     * Returns DeviceCodes of all locations if empty.
     *
     * @maps location_id
     */
    public function setLocationId(?string $locationId): void
    {
        $this->locationId['value'] = $locationId;
    }

    /**
     * Unsets Location Id.
     * If specified, only returns DeviceCodes of the specified location.
     * Returns DeviceCodes of all locations if empty.
     */
    public function unsetLocationId(): void
    {
        $this->locationId = [];
    }

    /**
     * Returns Product Type.
     */
    public function getProductType(): ?string
    {
        return $this->productType;
    }

    /**
     * Sets Product Type.
     *
     * @maps product_type
     */
    public function setProductType(?string $productType): void
    {
        $this->productType = $productType;
    }

    /**
     * Returns Status.
     * If specified, returns DeviceCodes with the specified statuses.
     * Returns DeviceCodes of status `PAIRED` and `UNPAIRED` if empty.
     * See [DeviceCodeStatus](#type-devicecodestatus) for possible values
     *
     * @return string[]|null
     */
    public function getStatus(): ?array
    {
        if (count($this->status) == 0) {
            return null;
        }
        return $this->status['value'];
    }

    /**
     * Sets Status.
     * If specified, returns DeviceCodes with the specified statuses.
     * Returns DeviceCodes of status `PAIRED` and `UNPAIRED` if empty.
     * See [DeviceCodeStatus](#type-devicecodestatus) for possible values
     *
     * @maps status
     *
     * @param string[]|null $status
     */
    public function setStatus(?array $status): void
    {
        $this->status['value'] = $status;
    }

    /**
     * Unsets Status.
     * If specified, returns DeviceCodes with the specified statuses.
     * Returns DeviceCodes of status `PAIRED` and `UNPAIRED` if empty.
     * See [DeviceCodeStatus](#type-devicecodestatus) for possible values
     */
    public function unsetStatus(): void
    {
        $this->status = [];
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
            $json['cursor']       = $this->cursor['value'];
        }
        if (!empty($this->locationId)) {
            $json['location_id']  = $this->locationId['value'];
        }
        if (isset($this->productType)) {
            $json['product_type'] = $this->productType;
        }
        if (!empty($this->status)) {
            $json['status']       = $this->status['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
