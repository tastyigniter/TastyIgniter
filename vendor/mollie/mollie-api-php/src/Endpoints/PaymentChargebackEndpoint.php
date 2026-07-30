<?php

namespace Mollie\Api\Endpoints;

use Mollie\Api\Resources\Chargeback;
use Mollie\Api\Resources\ChargebackCollection;
use Mollie\Api\Resources\LazyCollection;
use Mollie\Api\Resources\Payment;

class PaymentChargebackEndpoint extends CollectionEndpointAbstract
{
    protected $resourcePath = "payments_chargebacks";

    /**
     * Get the object that is used by this API endpoint. Every API endpoint uses one type of object.
     *
     * @return Chargeback
     */
    protected function getResourceObject()
    {
        return new Chargeback($this->client);
    }

    /**
     * Get the collection object that is used by this API endpoint. Every API endpoint uses one type of collection object.
     *
     * @param int $count
     * @param \stdClass $_links
     *
     * @return ChargebackCollection
     */
    protected function getResourceCollectionObject($count, $_links)
    {
        return new ChargebackCollection($this->client, $count, $_links);
    }

    /**
     * @param Payment $payment
     * @param string $chargebackId
     * @param array $parameters
     *
     * @return Chargeback
     * @throws \Mollie\Api\Exceptions\ApiException
     */
    public function getFor(Payment $payment, $chargebackId, array $parameters = [])
    {
        return $this->getForId($payment->id, $chargebackId, $parameters);
    }

    /**
     * @param string $paymentId
     * @param string $chargebackId
     * @param array $parameters
     *
     * @return Chargeback
     * @throws \Mollie\Api\Exceptions\ApiException
     */
    public function getForId($paymentId, $chargebackId, array $parameters = [])
    {
        $this->parentId = $paymentId;

        return parent::rest_read($chargebackId, $parameters);
    }

    /**
     * @param Payment $payment
     * @param array $parameters
     *
     * @return Chargeback
     * @throws \Mollie\Api\Exceptions\ApiException
     */
    public function listFor(Payment $payment, array $parameters = [])
    {
        return $this->listForId($payment->id, $parameters);
    }

    /**
     * Create an iterator for iterating over chargebacks for the given payment, retrieved from Mollie.
     *
     * @param Payment $payment
     * @param string $from The first resource ID you want to include in your list.
     * @param int $limit
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
     * @return \Mollie\Api\Resources\BaseCollection|\Mollie\Api\Resources\Chargeback
     * @throws \Mollie\Api\Exceptions\ApiException
     */
    public function listForId($paymentId, array $parameters = [])
    {
        $this->parentId = $paymentId;

        return parent::rest_list(null, null, $parameters);
    }

    /**
     * Create an iterator for iterating over chargebacks for the given payment id, retrieved from Mollie.
     *
     * @param string $paymentId
     * @param string $from The first resource ID you want to include in your list.
     * @param int $limit
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
}
