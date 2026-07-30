<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Specifies a decimal number range.
 */
class FloatNumberRange implements \JsonSerializable
{
    /**
     * @var array
     */
    private $startAt = [];

    /**
     * @var array
     */
    private $endAt = [];

    /**
     * Returns Start At.
     * A decimal value indicating where the range starts.
     */
    public function getStartAt(): ?string
    {
        if (count($this->startAt) == 0) {
            return null;
        }
        return $this->startAt['value'];
    }

    /**
     * Sets Start At.
     * A decimal value indicating where the range starts.
     *
     * @maps start_at
     */
    public function setStartAt(?string $startAt): void
    {
        $this->startAt['value'] = $startAt;
    }

    /**
     * Unsets Start At.
     * A decimal value indicating where the range starts.
     */
    public function unsetStartAt(): void
    {
        $this->startAt = [];
    }

    /**
     * Returns End At.
     * A decimal value indicating where the range ends.
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
     * A decimal value indicating where the range ends.
     *
     * @maps end_at
     */
    public function setEndAt(?string $endAt): void
    {
        $this->endAt['value'] = $endAt;
    }

    /**
     * Unsets End At.
     * A decimal value indicating where the range ends.
     */
    public function unsetEndAt(): void
    {
        $this->endAt = [];
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
        if (!empty($this->startAt)) {
            $json['start_at'] = $this->startAt['value'];
        }
        if (!empty($this->endAt)) {
            $json['end_at']   = $this->endAt['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
