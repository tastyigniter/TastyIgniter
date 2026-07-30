<?php

namespace Mollie\Api\Endpoints;

use Mollie\Api\Resources\LazyCollection;
use Mollie\Api\Resources\Payment;
use Mollie\Api\Resources\Refund;
use Mollie\Api\Resources\RefundCollection;

class PaymentRefundEndpoint extends CollectionEndpointAbstract
{
    protected $resourcePath = "payments_refunds";

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
     * @param Payment $payment
     * @param string $refundId
     * @param array $parameters
     *
     * @return Refund
     * @throws \Mollie\Api\Exceptions\ApiException
     */
    public function getFor(Payment $payment, $refundId, array $parameters = [])
    {
        return $this->getForId($payment->id, $refundId, $parameters);
    }

    /**
     * @param string $paymentId
     * @param string $refundId
     * @param array $parameters
     *
     * @return \Mollie\Api\Resources\Refund
     * @throws \Mollie\Api\Exceptions\ApiException
     */
    public function getForId($paymentId, $refundId, array $parameters = [])
    {
        $this->parentId = $paymentId;

        return parent::rest_read($refundId, $parameters);
    }

    /**
     * @param Payment $payment
     * @param array $parameters
     *
     * @return Refund
     * @throws \Mollie\Api\Exceptions\ApiException
     */
    public function listFor(Payment $payment, array $parameters = [])
    {
        return $this->listForId($payment->id, $parameters);
    }

    /**
     * Create an iterator for iterating over refunds for the given payment, retrieved from Mollie.
     *
     * @param Payment $payment
     * @param string|null $from The first resource ID you want to include in your list.
     * @param int|null $limit
     * @param array $parameters
     * @param bool $iterateBackwards Set to true for reverse order iteration (default is false).
     *
     * @return LazyCollection
     */
    public function iteratorFor(Payment $payment, ?string $from = null, ?int $limit = null, array $parameters = [], bool $iterateBackwards = false): LazyCollection
    {
        return $this->iteratorForId($payment->id, $from, $limit, $parameters, $iterateBackwards);
    }

    /**
     * @param string $paymentId
     * @param array $parameters
     *
     * @return \Mollie\Api\Resources\BaseCollection|\Mollie\Api\Resources\Refund
     * @throws \Mollie\Api\Exceptions\ApiException
     */
    public function listForId($paymentId, array $parameters = [])
    {
        $this->parentId = $paymentId;

        return parent::rest_list(null, null, $parameters);
    }

    /**
     * Create an iterator for iterating over refunds for the given payment id, retrieved from Mollie.
     *
     * @param string $paymentId
     * @param string|null $from The first resource ID you want to include in your list.
     * @param int|null $limit
     * @param array $parameters
     * @param bool $iterateBackwards Set to true for reverse order iteration (default is false).
     *
     * @return LazyCollection
     */
    public function iteratorForId(string $paymentId, ?string $from = null, ?int $limit = null, array $parameters = [], bool $iterateBackwards = false): LazyCollection
    {
        $this->parentId = $paymentId;

        return $this->rest_iterator($from, $limit, $parameters, $iterateBackwards);
    }


    /**
     * Creates a refund for a specific payment.
     *
     * @param Payment $payment
     * @param array $data
     * @param array $filters
     *
     * @return Refund
     * @throws \Mollie\Api\Exceptions\ApiException
     */
    public function createFor(Payment $payment, array $data, array $filters = [])
    {
        return $this->createForId($payment->id, $data, $filters);
    }

    /**
     * Creates a refund for a specific payment.
     *
     * @param string $paymentId
     * @param array $data
     * @param array $filters
     *
     * @return \Mollie\Api\Resources\Refund
     * @throws \Mollie\Api\Exceptions\ApiException
     */
    public function createForId(string $paymentId, array $data, array $filters = [])
    {
        $this->parentId = $paymentId;

        return parent::rest_create($data, $filters);
    }

    /**
     * @param \Mollie\Api\Resources\Payment $payment
     * @param string $refundId
     * @param array $parameters
     * @return null
     *
     * @throws \Mollie\Api\Exceptions\ApiException
     */
    public function cancelForPayment(Payment $payment, string $refundId, array $parameters = [])
    {
        $this->parentId = $payment->id;

        return $this->cancelForId($payment->id, $refundId, $parameters);
    }

    /**
     * @param string $paymentId
     * @param string $refundId
     * @param array $parameters
     * @return null
     *
     * @throws \Mollie\Api\Exceptions\ApiException
     */
    public function cancelForId(string $paymentId, string $refundId, array $parameters = [])
    {
        $this->parentId = $paymentId;

        $body = null;
        if (count($parameters) > 0) {
            $body = json_encode($parameters);
        }

        $this->client->performHttpCall(
            EndpointAbstract::REST_DELETE,
            $this->getResourcePath() . '/' . $refundId,
            $body
        );

        $this->getResourcePath();

        return null;
    }
}
