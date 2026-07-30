<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Information about fulfillment updates.
 */
class OrderFulfillmentUpdatedUpdate implements \JsonSerializable
{
    /**
     * @var array
     */
    private $fulfillmentUid = [];

    /**
     * @var string|null
     */
    private $oldState;

    /**
     * @var string|null
     */
    private $newState;

    /**
     * Returns Fulfillment Uid.
     * A unique ID that identifies the fulfillment only within this order.
     */
    public function getFulfillmentUid(): ?string
    {
        if (count($this->fulfillmentUid) == 0) {
            return null;
        }
        return $this->fulfillmentUid['value'];
    }

    /**
     * Sets Fulfillment Uid.
     * A unique ID that identifies the fulfillment only within this order.
     *
     * @maps fulfillment_uid
     */
    public function setFulfillmentUid(?string $fulfillmentUid): void
    {
        $this->fulfillmentUid['value'] = $fulfillmentUid;
    }

    /**
     * Unsets Fulfillment Uid.
     * A unique ID that identifies the fulfillment only within this order.
     */
    public function unsetFulfillmentUid(): void
    {
        $this->fulfillmentUid = [];
    }

    /**
     * Returns Old State.
     * The current state of this fulfillment.
     */
    public function getOldState(): ?string
    {
        return $this->oldState;
    }

    /**
     * Sets Old State.
     * The current state of this fulfillment.
     *
     * @maps old_state
     */
    public function setOldState(?string $oldState): void
    {
        $this->oldState = $oldState;
    }

    /**
     * Returns New State.
     * The current state of this fulfillment.
     */
    public function getNewState(): ?string
    {
        return $this->newState;
    }

    /**
     * Sets New State.
     * The current state of this fulfillment.
     *
     * @maps new_state
     */
    public function setNewState(?string $newState): void
    {
        $this->newState = $newState;
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
        if (!empty($this->fulfillmentUid)) {
            $json['fulfillment_uid'] = $this->fulfillmentUid['value'];
        }
        if (isset($this->oldState)) {
            $json['old_state']       = $this->oldState;
        }
        if (isset($this->newState)) {
            $json['new_state']       = $this->newState;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
