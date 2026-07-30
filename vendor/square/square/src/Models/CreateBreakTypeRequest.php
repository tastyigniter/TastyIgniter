<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * A request to create a new `BreakType`.
 */
class CreateBreakTypeRequest implements \JsonSerializable
{
    /**
     * @var string|null
     */
    private $idempotencyKey;

    /**
     * @var BreakType
     */
    private $breakType;

    /**
     * @param BreakType $breakType
     */
    public function __construct(BreakType $breakType)
    {
        $this->breakType = $breakType;
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
     * Returns Break Type.
     * A defined break template that sets an expectation for possible `Break`
     * instances on a `Shift`.
     */
    public function getBreakType(): BreakType
    {
        return $this->breakType;
    }

    /**
     * Sets Break Type.
     * A defined break template that sets an expectation for possible `Break`
     * instances on a `Shift`.
     *
     * @required
     * @maps break_type
     */
    public function setBreakType(BreakType $breakType): void
    {
        $this->breakType = $breakType;
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
        $json['break_type']          = $this->breakType;
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
