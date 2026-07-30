<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * A record of an employee's break during a shift.
 */
class MBreak implements \JsonSerializable
{
    /**
     * @var string|null
     */
    private $id;

    /**
     * @var string
     */
    private $startAt;

    /**
     * @var array
     */
    private $endAt = [];

    /**
     * @var string
     */
    private $breakTypeId;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $expectedDuration;

    /**
     * @var bool
     */
    private $isPaid;

    /**
     * @param string $startAt
     * @param string $breakTypeId
     * @param string $name
     * @param string $expectedDuration
     * @param bool $isPaid
     */
    public function __construct(
        string $startAt,
        string $breakTypeId,
        string $name,
        string $expectedDuration,
        bool $isPaid
    ) {
        $this->startAt = $startAt;
        $this->breakTypeId = $breakTypeId;
        $this->name = $name;
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
     * Returns Start At.
     * RFC 3339; follows the same timezone information as `Shift`. Precision up to
     * the minute is respected; seconds are truncated.
     */
    public function getStartAt(): string
    {
        return $this->startAt;
    }

    /**
     * Sets Start At.
     * RFC 3339; follows the same timezone information as `Shift`. Precision up to
     * the minute is respected; seconds are truncated.
     *
     * @required
     * @maps start_at
     */
    public function setStartAt(string $startAt): void
    {
        $this->startAt = $startAt;
    }

    /**
     * Returns End At.
     * RFC 3339; follows the same timezone information as `Shift`. Precision up to
     * the minute is respected; seconds are truncated.
     */
    public function getEndAt(): ?string
    {
        if (count($this->endAt) == 0) {
            return null;
        }
        return $this->endAt['value'];
    }

    /**
     * Sets End At.
     * RFC 3339; follows the same timezone information as `Shift`. Precision up to
     * the minute is respected; seconds are truncated.
     *
     * @maps end_at
     */
    public function setEndAt(?string $endAt): void
    {
        $this->endAt['value'] = $endAt;
    }

    /**
     * Unsets End At.
     * RFC 3339; follows the same timezone information as `Shift`. Precision up to
     * the minute is respected; seconds are truncated.
     */
    public function unsetEndAt(): void
    {
        $this->endAt = [];
    }

    /**
     * Returns Break Type Id.
     * The `BreakType` that this `Break` was templated on.
     */
    public function getBreakTypeId(): string
    {
        return $this->breakTypeId;
    }

    /**
     * Sets Break Type Id.
     * The `BreakType` that this `Break` was templated on.
     *
     * @required
     * @maps break_type_id
     */
    public function setBreakTypeId(string $breakTypeId): void
    {
        $this->breakTypeId = $breakTypeId;
    }

    /**
     * Returns Name.
     * A human-readable name.
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Sets Name.
     * A human-readable name.
     *
     * @required
     * @maps name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * Returns Expected Duration.
     * Format: RFC-3339 P[n]Y[n]M[n]DT[n]H[n]M[n]S. The expected length of
     * the break.
     */
    public function getExpectedDuration(): string
    {
        return $this->expectedDuration;
    }

    /**
     * Sets Expected Duration.
     * Format: RFC-3339 P[n]Y[n]M[n]DT[n]H[n]M[n]S. The expected length of
     * the break.
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
        $json['start_at']          = $this->startAt;
        if (!empty($this->endAt)) {
            $json['end_at']        = $this->endAt['value'];
        }
        $json['break_type_id']     = $this->breakTypeId;
        $json['name']              = $this->name;
        $json['expected_duration'] = $this->expectedDuration;
        $json['is_paid']           = $this->isPaid;
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
