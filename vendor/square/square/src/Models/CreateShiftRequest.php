<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Represents a request to create a `Shift`.
 */
class CreateShiftRequest implements \JsonSerializable
{
    /**
     * @var string|null
     */
    private $idempotencyKey;

    /**
     * @var Shift
     */
    private $shift;

    /**
     * @param Shift $shift
     */
    public function __construct(Shift $shift)
    {
        $this->shift = $shift;
    }

    /**
     * Returns Idempotency Key.
     * A unique string value to ensure the idempotency of the operation.
     */
    public function getIdempotencyKey(): ?string
    {
        return $this->idempotencyKey;
    }

    /**
     * Sets Idempotency Key.
     * A unique string value to ensure the idempotency of the operation.
     *
     * @maps idempotency_key
     */
    public function setIdempotencyKey(?string $idempotencyKey): void
    {
        $this->idempotencyKey = $idempotencyKey;
    }

    /**
     * Returns Shift.
     * A record of the hourly rate, start, and end times for a single work shift
     * for an employee. This might include a record of the start and end times for breaks
     * taken during the shift.
     */
    public function getShift(): Shift
    {
        return $this->shift;
    }

    /**
     * Sets Shift.
     * A record of the hourly rate, start, and end times for a single work shift
     * for an employee. This might include a record of the start and end times for breaks
     * taken during the shift.
     *
     * @required
     * @maps shift
     */
    public function setShift(Shift $shift): void
    {
        $this->shift = $shift;
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
        if (isset($this->idempotencyKey)) {
            $json['idempotency_key'] = $this->idempotencyKey;
        }
        $json['shift']               = $this->shift;
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
