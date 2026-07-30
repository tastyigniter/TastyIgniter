<?php

namespace Mollie\Api\Endpoints;

use Mollie\Api\Resources\Order;
use Mollie\Api\Resources\Refund;
use Mollie\Api\Resources\RefundCollection;

class OrderRefundEndpoint extends CollectionEndpointAbstract
{
    protected $resourcePath = "orders_refunds";

    /**
     * Get the object that is used by this API endpoint. Every API endpoint uses one type of object.
     *
     * @return Refund
     */
    protected function getResourceObject()
    {
        return new Refund($this->client);
    }

    /**
     * Get the collection object that is used by this API endpoint. Every API endpoint uses one type of collection object.
     *
     * @param int $count
     * @param \stdClass $_links
     *
     * @return RefundCollection
     */
    protected function getResourceCollectionObject($count, $_links)
    {
        return new RefundCollection($this->client, $count, $_links);
    }

    /**
     * Refund some order lines. You can provide an empty array for the
     * "lines" data to refund all eligible lines for this order.
     *
     * @param Order $order
     * @param array $data
     * @param array $filters
     *
     * @return Refund
     * @throws \Mollie\Api\Exceptions\ApiException
     */
    public function createFor(Order $order, array $data, array $filters = [])
    {
        return $this->createForId($order->id, $data, $filters);
    }

    /**
     * Refund some order lines. You can provide an empty array for the
     * "lines" data to refund all eligible lines for this order.
     *
     * @param string $orderId
     * @param array $data
     * @param array $filters
     *
     * @return \Mollie\Api\Resources\Refund
     * @throws \Mollie\Api\Exceptions\ApiException
     */
    public function createForId($orderId, array $data, array $filters = [])
    {
        $this->parentId = $orderId;

        return parent::rest_create($data, $filters);
    }

    /**
     * @param $orderId
     * @param array $parameters
     * @return RefundCollection
     * @throws \Mollie\Api\Exceptions\ApiException
     */
    public function pageForId($orderId, array $parameters = [])
    {
        $this->parentId = $orderId;

        return parent::rest_list(null, null, $parameters);
    }

    /**
     * @param \Mollie\Api\Resources\Order $order
     * @param array $parameters
     * @return \Mollie\Api\Resources\RefundCollection
     * @throws \Mollie\Api\Exceptions\ApiException
     */
    public function pageFor(Order $order, array $parameters = [])
    {
        return $this->pageForId($order->id, $parameters);
    }
}
