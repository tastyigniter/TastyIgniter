<?php

namespace Mollie\Api\Endpoints;

use Mollie\Api\Resources\LazyCollection;
use Mollie\Api\Resources\Payment;
use Mollie\Api\Resources\PaymentCollection;

class SettlementPaymentEndpoint extends CollectionEndpointAbstract
{
    protected $resourcePath = "settlements_payments";

    /**
     * @inheritDoc
     */
    protected function getResourceObject()
    {
        return new Payment($this->client);
    }

    /**
     * @inheritDoc
     */
    protected function getResourceCollectionObject($count, $_links)
    {
        return new PaymentCollection($this->client, $count, $_links);
    }

    /**
     * Retrieves a collection of Payments from Mollie.
     *
     * @param string $settlementId
     * @param string $from The first payment ID you want to include in your list.
     * @param int $limit
     * @param array $parameters
     *
     * @return mixed
     * @throws \Mollie\Api\Exceptions\ApiException
     */
    public function pageForId($settlementId, $from = null, $limit = null, array $parameters = [])
    {
        $this->parentId = $settlementId;

        return $this->rest_list($from, $limit, $parameters);
    }

    /**
     * Create an iterator for iterating over payments for the given settlement id, retrieved from Mollie.
     *
     * @param string $settlementId
     * @param string $from The first resource ID you want to include in your list.
     * @param int $limit
     * @param array $parameters
     * @param bool $iterateBackwards Set to true for reverse order iteration (default is false).
     *
     * @return LazyCollection
     */
    public function iteratorForId(string $settlementId, ?string $from = null, ?int $limit = null, array $parameters = [], bool $iterateBackwards = false): LazyCollection
    {
        $this->parentId = $settlementId;

        return $this->rest_iterator($from, $limit, $parameters, $iterateBackwards);
    }
}
