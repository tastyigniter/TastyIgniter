<?php

namespace Mollie\Api\Resources;

class Shipment extends BaseResource
{
    /**
     * The shipment’s unique identifier,
     *
     * @example shp_3wmsgCJN4U
     * @var string
     */
    public $id;

    /**
     * Id of the order.
     *
     * @example ord_8wmqcHMN4U
     * @var string
     */
    public $orderId;

    /**
     * UTC datetime the shipment was created in ISO-8601 format.
     *
     * @example "2013-12-25T10:30:54+00:00"
     * @var string|null
     */
    public $createdAt;

    /**
     * The order object lines contain the actual things the customer bought.
     * @var array|object[]
     */
    public $lines;

    /**
     * An object containing tracking details for the shipment, if available.
     * @var \stdClass|null
     */
    public $tracking;

    /**
     * An object with several URL objects relevant to the customer. Every URL object will contain an href and a type field.
     * @var \stdClass
     */
    public $_links;

    /**
     * Does this shipment offer track and trace?
     *
     * @return bool
     */
    public function hasTracking()
    {
        return $this->tracking !== null;
    }

    /**
     * Does this shipment offer a track and trace code?
     *
     * @return bool
     */
    public function hasTrackingUrl()
    {
        return $this->hasTracking() && ! empty($this->tracking->url);
    }

    /**
     * Retrieve the track and trace url. Returns null if there is no url available.
     *
     * @return string|null
     */
    public function getTrackingUrl()
    {
        if (! $this->hasTrackingUrl()) {
            return null;
        }

        return $this->tracking->url;
    }

    /**
     * Get the line value objects
     *
     * @return OrderLineCollection
     */
    public function lines()
    {
        return ResourceFactory::createBaseResourceCollection(
            $this->client,
            OrderLine::class,
            $this->lines
        );
    }

    /**
     * Get the Order object for this shipment
     *
     * @return Order
     * @throws \Mollie\Api\Exceptions\ApiException
     */
    public function order()
    {
        return $this->client->orders->get($this->orderId);
    }

    /**
     * Save changes made to this shipment.
     *
     * @return BaseResource|Shipment
     * @throws \Mollie\Api\Exceptions\ApiException
     */
    public function update()
    {
        $body = [
            "tracking" => $this->tracking,
        ];

        $result = $this->client->shipments->update($this->orderId, $this->id, $body);

        return ResourceFactory::createFromApiResult($result, new Shipment($this->client));
    }
}
