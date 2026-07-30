<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Represents details about a `DEACTIVATE` [gift card activity type]($m/GiftCardActivityType).
 */
class GiftCardActivityDeactivate implements \JsonSerializable
{
    /**
     * @var string
     */
    private $reason;

    /**
     * @param string $reason
     */
    public function __construct(string $reason)
    {
        $this->reason = $reason;
    }

    /**
     * Returns Reason.
     * Indicates the reason for deactivating a [gift card]($m/GiftCard).
     */
    public function getReason(): string
    {
        return $this->reason;
    }

    /**
     * Sets Reason.
     * Indicates the reason for deactivating a [gift card]($m/GiftCard).
     *
     * @required
     * @maps reason
     */
    public function setReason(string $reason): void
    {
        $this->reason = $reason;
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
        $json['reason'] = $this->reason;
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
