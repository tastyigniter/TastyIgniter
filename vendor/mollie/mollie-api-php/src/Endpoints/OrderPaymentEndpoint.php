<?php

namespace Mollie\Api\Endpoints;

use Mollie\Api\Resources\Order;
use Mollie\Api\Resources\Payment;
use Mollie\Api\Resources\PaymentCollection;

class OrderPaymentEndpoint extends CollectionEndpointAbstract
{
    protected $resourcePath = "orders_payments";

    /**
     * @var string
     */
    public const RESOURCE_ID_PREFIX = 'tr_';

    /**
     * Get the object that is used by this API endpoint. Every API endpoint uses one
     * type of object.
     *
     * @return \Mollie\Api\Resources\Payment
     */
    protected function getResourceObject()
    {
        return new Payment($this->client);
    }

    /**
     * Get the collection object that is used by this API endpoint. Every API
     * endpoint uses one type of collection object.
     *
     * @param int $count
     * @param \stdClass $_links
     *
     * @return \Mollie\Api\Resources\PaymentCollection
     */
    protected function getResourceCollectionObject($count, $_links)
    {
        return new PaymentCollection($this->client, $count, $_links);
    }

    /**
     * Creates a payment in Mollie for a specific order.
     *
     * @param \Mollie\Api\Resources\Order $order
     * @param array $data An array containing details on the order payment.
     * @param array $filters
     *
     * @return \Mollie\Api\Resources\Payment
     * @throws \Mollie\Api\Exceptions\ApiException
     */
    public function createFor(Order $order, array $data, array $filters = [])
    {
        return $this->createForId($order->id, $data, $filters);
    }

    /**
     * Creates a payment in Mollie for a specific order ID.
     *
     * @param string $orderId
     * @param array $data An array containing details on the order payment.
     * @param array $filters
     *
     * @return \Mollie\Api\Resources\Payment
     * @throws \Mollie\Api\Exceptions\ApiException
     */
    public function createForId($orderId, array $data, array $filters = [])
    {
        $this->parentId = $orderId;

        return $this->rest_create($data, $filters);
    }
}
