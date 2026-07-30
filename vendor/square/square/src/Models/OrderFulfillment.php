<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Contains details about how to fulfill this order.
 * Orders can only be created with at most one fulfillment using the API.
 * However, orders returned by the Orders API might contain multiple fulfillments because sellers can
 * create multiple fulfillments using Square products such as Square Online.
 */
class OrderFulfillment implements \JsonSerializable
{
    /**
     * @var array
     */
    private $uid = [];

    /**
     * @var string|null
     */
    private $type;

    /**
     * @var string|null
     */
    private $state;

    /**
     * @var string|null
     */
    private $lineItemApplication;

    /**
     * @var OrderFulfillmentFulfillmentEntry[]|null
     */
    private $entries;

    /**
     * @var array
     */
    private $metadata = [];

    /**
     * @var OrderFulfillmentPickupDetails|null
     */
    private $pickupDetails;

    /**
     * @var OrderFulfillmentShipmentDetails|null
     */
    private $shipmentDetails;

    /**
     * @var OrderFulfillmentDeliveryDetails|null
     */
    private $deliveryDetails;

    /**
     * Returns Uid.
     * A unique ID that identifies the fulfillment only within this order.
     */
    public function getUid(): ?string
    {
        if (count($this->uid) == 0) {
            return null;
        }
        return $this->uid['value'];
    }

    /**
     * Sets Uid.
     * A unique ID that identifies the fulfillment only within this order.
     *
     * @maps uid
     */
    public function setUid(?string $uid): void
    {
        $this->uid['value'] = $uid;
    }

    /**
     * Unsets Uid.
     * A unique ID that identifies the fulfillment only within this order.
     */
    public function unsetUid(): void
    {
        $this->uid = [];
    }

    /**
     * Returns Type.
     * The type of fulfillment.
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * Sets Type.
     * The type of fulfillment.
     *
     * @maps type
     */
    public function setType(?string $type): void
    {
        $this->type = $type;
    }

    /**
     * Returns State.
     * The current state of this fulfillment.
     */
    public function getState(): ?string
    {
        return $this->state;
    }

    /**
     * Sets State.
     * The current state of this fulfillment.
     *
     * @maps state
     */
    public function setState(?string $state): void
    {
        $this->state = $state;
    }

    /**
     * Returns Line Item Application.
     * The `line_item_application` describes what order line items this fulfillment applies
     * to. It can be `ALL` or `ENTRY_LIST` with a supplied list of fulfillment entries.
     */
    public function getLineItemApplication(): ?string
    {
        return $this->lineItemApplication;
    }

    /**
     * Sets Line Item Application.
     * The `line_item_application` describes what order line items this fulfillment applies
     * to. It can be `ALL` or `ENTRY_LIST` with a supplied list of fulfillment entries.
     *
     * @maps line_item_application
     */
    public function setLineItemApplication(?string $lineItemApplication): void
    {
        $this->lineItemApplication = $lineItemApplication;
    }

    /**
     * Returns Entries.
     * A list of entries pertaining to the fulfillment of an order. Each entry must reference
     * a valid `uid` for an order line item in the `line_item_uid` field, as well as a `quantity` to
     * fulfill.
     * Multiple entries can reference the same line item `uid`, as long as the total quantity among
     * all fulfillment entries referencing a single line item does not exceed the quantity of the
     * order's line item itself.
     * An order cannot be marked as `COMPLETED` before all fulfillments are `COMPLETED`,
     * `CANCELED`, or `FAILED`. Fulfillments can be created and completed independently
     * before order completion.
     *
     * @return OrderFulfillmentFulfillmentEntry[]|null
     */
    public function getEntries(): ?array
    {
        return $this->entries;
    }

    /**
     * Sets Entries.
     * A list of entries pertaining to the fulfillment of an order. Each entry must reference
     * a valid `uid` for an order line item in the `line_item_uid` field, as well as a `quantity` to
     * fulfill.
     * Multiple entries can reference the same line item `uid`, as long as the total quantity among
     * all fulfillment entries referencing a single line item does not exceed the quantity of the
     * order's line item itself.
     * An order cannot be marked as `COMPLETED` before all fulfillments are `COMPLETED`,
     * `CANCELED`, or `FAILED`. Fulfillments can be created and completed independently
     * before order completion.
     *
     * @maps entries
     *
     * @param OrderFulfillmentFulfillmentEntry[]|null $entries
     */
    public function setEntries(?array $entries): void
    {
        $this->entries = $entries;
    }

    /**
     * Returns Metadata.
     * Application-defined data attached to this fulfillment. Metadata fields are intended
     * to store descriptive references or associations with an entity in another system or store brief
     * information about the object. Square does not process this field; it only stores and returns it
     * in relevant API calls. Do not use metadata to store any sensitive information (such as personally
     * identifiable information or card details).
     * Keys written by applications must be 60 characters or less and must be in the character set
     * `[a-zA-Z0-9_-]`. Entries can also include metadata generated by Square. These keys are prefixed
     * with a namespace, separated from the key with a ':' character.
     * Values have a maximum length of 255 characters.
     * An application can have up to 10 entries per metadata field.
     * Entries written by applications are private and can only be read or modified by the same
     * application.
     * For more information, see [Metadata](https://developer.squareup.com/docs/build-basics/metadata).
     *
     * @return array<string,string>|null
     */
    public function getMetadata(): ?array
    {
        if (count($this->metadata) == 0) {
            return null;
        }
        return $this->metadata['value'];
    }

    /**
     * Sets Metadata.
     * Application-defined data attached to this fulfillment. Metadata fields are intended
     * to store descriptive references or associations with an entity in another system or store brief
     * information about the object. Square does not process this field; it only stores and returns it
     * in relevant API calls. Do not use metadata to store any sensitive information (such as personally
     * identifiable information or card details).
     * Keys written by applications must be 60 characters or less and must be in the character set
     * `[a-zA-Z0-9_-]`. Entries can also include metadata generated by Square. These keys are prefixed
     * with a namespace, separated from the key with a ':' character.
     * Values have a maximum length of 255 characters.
     * An application can have up to 10 entries per metadata field.
     * Entries written by applications are private and can only be read or modified by the same
     * application.
     * For more information, see [Metadata](https://developer.squareup.com/docs/build-basics/metadata).
     *
     * @maps metadata
     *
     * @param array<string,string>|null $metadata
     */
    public function setMetadata(?array $metadata): void
    {
        $this->metadata['value'] = $metadata;
    }

    /**
     * Unsets Metadata.
     * Application-defined data attached to this fulfillment. Metadata fields are intended
     * to store descriptive references or associations with an entity in another system or store brief
     * information about the object. Square does not process this field; it only stores and returns it
     * in relevant API calls. Do not use metadata to store any sensitive information (such as personally
     * identifiable information or card details).
     * Keys written by applications must be 60 characters or less and must be in the character set
     * `[a-zA-Z0-9_-]`. Entries can also include metadata generated by Square. These keys are prefixed
     * with a namespace, separated from the key with a ':' character.
     * Values have a maximum length of 255 characters.
     * An application can have up to 10 entries per metadata field.
     * Entries written by applications are private and can only be read or modified by the same
     * application.
     * For more information, see [Metadata](https://developer.squareup.com/docs/build-basics/metadata).
     */
    public function unsetMetadata(): void
    {
        $this->metadata = [];
    }

    /**
     * Returns Pickup Details.
     * Contains details necessary to fulfill a pickup order.
     */
    public function getPickupDetails(): ?OrderFulfillmentPickupDetails
    {
        return $this->pickupDetails;
    }

    /**
     * Sets Pickup Details.
     * Contains details necessary to fulfill a pickup order.
     *
     * @maps pickup_details
     */
    public function setPickupDetails(?OrderFulfillmentPickupDetails $pickupDetails): void
    {
        $this->pickupDetails = $pickupDetails;
    }

    /**
     * Returns Shipment Details.
     * Contains the details necessary to fulfill a shipment order.
     */
    public function getShipmentDetails(): ?OrderFulfillmentShipmentDetails
    {
        return $this->shipmentDetails;
    }

    /**
     * Sets Shipment Details.
     * Contains the details necessary to fulfill a shipment order.
     *
     * @maps shipment_details
     */
    public function setShipmentDetails(?OrderFulfillmentShipmentDetails $shipmentDetails): void
    {
        $this->shipmentDetails = $shipmentDetails;
    }

    /**
     * Returns Delivery Details.
     * Describes delivery details of an order fulfillment.
     */
    public function getDeliveryDetails(): ?OrderFulfillmentDeliveryDetails
    {
        return $this->deliveryDetails;
    }

    /**
     * Sets Delivery Details.
     * Describes delivery details of an order fulfillment.
     *
     * @maps delivery_details
     */
    public function setDeliveryDetails(?OrderFulfillmentDeliveryDetails $deliveryDetails): void
    {
        $this->deliveryDetails = $deliveryDetails;
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
        if (!empty($this->uid)) {
            $json['uid']                   = $this->uid['value'];
        }
        if (isset($this->type)) {
            $json['type']                  = $this->type;
        }
        if (isset($this->state)) {
            $json['state']                 = $this->state;
        }
        if (isset($this->lineItemApplication)) {
            $json['line_item_application'] = $this->lineItemApplication;
        }
        if (isset($this->entries)) {
            $json['entries']               = $this->entries;
        }
        if (!empty($this->metadata)) {
            $json['metadata']              = $this->metadata['value'];
        }
        if (isset($this->pickupDetails)) {
            $json['pickup_details']        = $this->pickupDetails;
        }
        if (isset($this->shipmentDetails)) {
            $json['shipment_details']      = $this->shipmentDetails;
        }
        if (isset($this->deliveryDetails)) {
            $json['delivery_details']      = $this->deliveryDetails;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
