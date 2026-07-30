<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Provides information about the subscription event.
 */
class SubscriptionEventInfo implements \JsonSerializable
{
    /**
     * @var array
     */
    private $detail = [];

    /**
     * @var string|null
     */
    private $code;

    /**
     * Returns Detail.
     * A human-readable explanation for the event.
     */
    public function getDetail(): ?string
    {
        if (count($this->detail) == 0) {
            return null;
        }
        return $this->detail['value'];
    }

    /**
     * Sets Detail.
     * A human-readable explanation for the event.
     *
     * @maps detail
     */
    public function setDetail(?string $detail): void
    {
        $this->detail['value'] = $detail;
    }

    /**
     * Unsets Detail.
     * A human-readable explanation for the event.
     */
    public function unsetDetail(): void
    {
        $this->detail = [];
    }

    /**
     * Returns Code.
     * Supported info codes of a subscription event.
     */
    public function getCode(): ?string
    {
        return $this->code;
    }

    /**
     * Sets Code.
     * Supported info codes of a subscription event.
     *
     * @maps code
     */
    public function setCode(?string $code): void
    {
        $this->code = $code;
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
        if (!empty($this->detail)) {
            $json['detail'] = $this->detail['value'];
        }
        if (isset($this->code)) {
            $json['code']   = $this->code;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
