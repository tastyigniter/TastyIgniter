<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * A defined break template that sets an expectation for possible `Break`
 * instances on a `Shift`.
 */
class BreakType implements \JsonSerializable
{
    /**
     * @var string|null
     */
    private $id;

    /**
     * @var string
     */
    private $locationId;

    /**
     * @var string
     */
    private $breakName;

    /**
     * @var string
     */
    private $expectedDuration;

    /**
     * @var bool
     */
    private $isPaid;

    /**
     * @var int|null
     */
    private $version;

    /**
     * @var string|null
     */
    private $createdAt;

    /**
     * @var string|null
     */
    private $updatedAt;

    /**
     * @param string $locationId
     * @param string $breakName
     * @param string $expectedDuration
     * @param bool $isPaid
     */
    public function __construct(string $locationId, string $breakName, string $expectedDuration, bool $isPaid)
    {
        $this->locationId = $locationId;
        $this->breakName = $breakName;
        $this->expectedDuration = $expectedDuration;
        $this->isPaid = $isPaid;
    }

    /**
     * Returns Id.
     * The UUID for this object.
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * Sets Id.
     * The UUID for this object.
     *
     * @maps id
     */
    public function setId(?string $id): void
    {
        $this->id = $id;
    }

    /**
     * Returns Location Id.
     * The ID of the business location this type of break applies to.
     */
    public function getLocationId(): string
    {
        return $this->locationId;
    }

    /**
     * Sets Location Id.
     * The ID of the business location this type of break applies to.
     *
     * @required
     * @maps location_id
     */
    public function setLocationId(string $locationId): void
    {
        $this->locationId = $locationId;
    }

    /**
     * Returns Break Name.
     * A human-readable name for this type of break. The name is displayed to
     * employees in Square products.
     */
    public function getBreakName(): string
    {
        return $this->breakName;
    }

    /**
     * Sets Break Name.
     * A human-readable name for this type of break. The name is displayed to
     * employees in Square products.
     *
     * @required
     * @maps break_name
     */
    public function setBreakName(string $breakName): void
    {
        $this->breakName = $breakName;
    }

    /**
     * Returns Expected Duration.
     * Format: RFC-3339 P[n]Y[n]M[n]DT[n]H[n]M[n]S. The expected length of
     * this break. Precision less than minutes is truncated.
     *
     * Example for break expected duration of 15 minutes: T15M
     */
    public function getExpectedDuration(): string
    {
        return $this->expectedDuration;
    }

    /**
     * Sets Expected Duration.
     * Format: RFC-3339 P[n]Y[n]M[n]DT[n]H[n]M[n]S. The expected length of
     * this break. Precision less than minutes is truncated.
     *
     * Example for break expected duration of 15 minutes: T15M
     *
     * @required
     * @maps expected_duration
     */
    public function setExpectedDuration(string $expectedDuration): void
    {
        $this->expectedDuration = $expectedDuration;
    }

    /**
     * Returns Is Paid.
     * Whether this break counts towards time worked for compensation
     * purposes.
     */
    public function getIsPaid(): bool
    {
        return $this->isPaid;
    }

    /**
     * Sets Is Paid.
     * Whether this break counts towards time worked for compensation
     * purposes.
     *
     * @required
     * @maps is_paid
     */
    public function setIsPaid(bool $isPaid): void
    {
        $this->isPaid = $isPaid;
    }

    /**
     * Returns Version.
     * Used for resolving concurrency issues. The request fails if the version
     * provided does not match the server version at the time of the request. If a value is not
     * provided, Square's servers execute a "blind" write; potentially
     * overwriting another writer's data.
     */
    public function getVersion(): ?int
    {
        return $this->version;
    }

    /**
     * Sets Version.
     * Used for resolving concurrency issues. The request fails if the version
     * provided does not match the server version at the time of the request. If a value is not
     * provided, Square's servers execute a "blind" write; potentially
     * overwriting another writer's data.
     *
     * @maps version
     */
    public function setVersion(?int $version): void
    {
        $this->version = $version;
    }

    /**
     * Returns Created At.
     * A read-only timestamp in RFC 3339 format.
     */
    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }

    /**
     * Sets Created At.
     * A read-only timestamp in RFC 3339 format.
     *
     * @maps created_at
     */
    public function setCreatedAt(?string $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * Returns Updated At.
     * A read-only timestamp in RFC 3339 format.
     */
    public function getUpdatedAt(): ?string
    {
        return $this->updatedAt;
    }

    /**
     * Sets Updated At.
     * A read-only timestamp in RFC 3339 format.
     *
     * @maps updated_at
     */
    public function setUpdatedAt(?string $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
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
            $json['id']            = $this->id;
        }
        $json['location_id']       = $this->locationId;
        $json['break_name']        = $this->breakName;
        $json['expected_duration'] = $this->expectedDuration;
        $json['is_paid']           = $this->isPaid;
        if (isset($this->version)) {
            $json['version']       = $this->version;
        }
        if (isset($this->createdAt)) {
            $json['created_at']    = $this->createdAt;
        }
        if (isset($this->updatedAt)) {
            $json['updated_at']    = $this->updatedAt;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
