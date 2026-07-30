<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

class DeviceCode implements \JsonSerializable
{
    /**
     * @var string|null
     */
    private $id;

    /**
     * @var array
     */
    private $name = [];

    /**
     * @var string|null
     */
    private $code;

    /**
     * @var string|null
     */
    private $deviceId;

    /**
     * @var string
     */
    private $productType;

    /**
     * @var array
     */
    private $locationId = [];

    /**
     * @var string|null
     */
    private $status;

    /**
     * @var string|null
     */
    private $pairBy;

    /**
     * @var string|null
     */
    private $createdAt;

    /**
     * @var string|null
     */
    private $statusChangedAt;

    /**
     * @var string|null
     */
    private $pairedAt;

    /**
     * Returns Id.
     * The unique id for this device code.
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * Sets Id.
     * The unique id for this device code.
     *
     * @maps id
     */
    public function setId(?string $id): void
    {
        $this->id = $id;
    }

    /**
     * Returns Name.
     * An optional user-defined name for the device code.
     */
    public function getName(): ?string
    {
        if (count($this->name) == 0) {
            return null;
        }
        return $this->name['value'];
    }

    /**
     * Sets Name.
     * An optional user-defined name for the device code.
     *
     * @maps name
     */
    public function setName(?string $name): void
    {
        $this->name['value'] = $name;
    }

    /**
     * Unsets Name.
     * An optional user-defined name for the device code.
     */
    public function unsetName(): void
    {
        $this->name = [];
    }

    /**
     * Returns Code.
     * The unique code that can be used to login.
     */
    public function getCode(): ?string
    {
        return $this->code;
    }

    /**
     * Sets Code.
     * The unique code that can be used to login.
     *
     * @maps code
     */
    public function setCode(?string $code): void
    {
        $this->code = $code;
    }

    /**
     * Returns Device Id.
     * The unique id of the device that used this code. Populated when the device is paired up.
     */
    public function getDeviceId(): ?string
    {
        return $this->deviceId;
    }

    /**
     * Sets Device Id.
     * The unique id of the device that used this code. Populated when the device is paired up.
     *
     * @maps device_id
     */
    public function setDeviceId(?string $deviceId): void
    {
        $this->deviceId = $deviceId;
    }

    /**
     * Returns Product Type.
     */
    public function getProductType(): string
    {
        return $this->productType;
    }

    /**
     * Sets Product Type.
     *
     * @maps product_type
     */
    public function setProductType(string $productType): void
    {
        $this->productType = $productType;
    }

    /**
     * Returns Location Id.
     * The location assigned to this code.
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
     * The location assigned to this code.
     *
     * @maps location_id
     */
    public function setLocationId(?string $locationId): void
    {
        $this->locationId['value'] = $locationId;
    }

    /**
     * Unsets Location Id.
     * The location assigned to this code.
     */
    public function unsetLocationId(): void
    {
        $this->locationId = [];
    }

    /**
     * Returns Status.
     * DeviceCode.Status enum.
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * Sets Status.
     * DeviceCode.Status enum.
     *
     * @maps status
     */
    public function setStatus(?string $status): void
    {
        $this->status = $status;
    }

    /**
     * Returns Pair By.
     * When this DeviceCode will expire and no longer login. Timestamp in RFC 3339 format.
     */
    public function getPairBy(): ?string
    {
        return $this->pairBy;
    }

    /**
     * Sets Pair By.
     * When this DeviceCode will expire and no longer login. Timestamp in RFC 3339 format.
     *
     * @maps pair_by
     */
    public function setPairBy(?string $pairBy): void
    {
        $this->pairBy = $pairBy;
    }

    /**
     * Returns Created At.
     * When this DeviceCode was created. Timestamp in RFC 3339 format.
     */
    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }

    /**
     * Sets Created At.
     * When this DeviceCode was created. Timestamp in RFC 3339 format.
     *
     * @maps created_at
     */
    public function setCreatedAt(?string $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * Returns Status Changed At.
     * When this DeviceCode's status was last changed. Timestamp in RFC 3339 format.
     */
    public function getStatusChangedAt(): ?string
    {
        return $this->statusChangedAt;
    }

    /**
     * Sets Status Changed At.
     * When this DeviceCode's status was last changed. Timestamp in RFC 3339 format.
     *
     * @maps status_changed_at
     */
    public function setStatusChangedAt(?string $statusChangedAt): void
    {
        $this->statusChangedAt = $statusChangedAt;
    }

    /**
     * Returns Paired At.
     * When this DeviceCode was paired. Timestamp in RFC 3339 format.
     */
    public function getPairedAt(): ?string
    {
        return $this->pairedAt;
    }

    /**
     * Sets Paired At.
     * When this DeviceCode was paired. Timestamp in RFC 3339 format.
     *
     * @maps paired_at
     */
    public function setPairedAt(?string $pairedAt): void
    {
        $this->pairedAt = $pairedAt;
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
        if (isset($this->id)) {
            $json['id']                = $this->id;
        }
        if (!empty($this->name)) {
            $json['name']              = $this->name['value'];
        }
        if (isset($this->code)) {
            $json['code']              = $this->code;
        }
        if (isset($this->deviceId)) {
            $json['device_id']         = $this->deviceId;
        }
        $json['product_type']          = $this->productType;
        if (!empty($this->locationId)) {
            $json['location_id']       = $this->locationId['value'];
        }
        if (isset($this->status)) {
            $json['status']            = $this->status;
        }
        if (isset($this->pairBy)) {
            $json['pair_by']           = $this->pairBy;
        }
        if (isset($this->createdAt)) {
            $json['created_at']        = $this->createdAt;
        }
        if (isset($this->statusChangedAt)) {
            $json['status_changed_at'] = $this->statusChangedAt;
        }
        if (isset($this->pairedAt)) {
            $json['paired_at']         = $this->pairedAt;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
