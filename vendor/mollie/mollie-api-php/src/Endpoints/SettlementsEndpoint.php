<?php

namespace Mollie\Api\Endpoints;

use Mollie\Api\Exceptions\ApiException;
use Mollie\Api\Resources\LazyCollection;
use Mollie\Api\Resources\Settlement;
use Mollie\Api\Resources\SettlementCollection;

class SettlementsEndpoint extends CollectionEndpointAbstract
{
    protected $resourcePath = "settlements";

    /**
     * Get the object that is used by this API. Every API uses one type of object.
     *
     * @return \Mollie\Api\Resources\BaseResource
     */
    protected function getResourceObject()
    {
        return new Settlement($this->client);
    }

    /**
     * Get the collection object that is used by this API. Every API uses one type of collection object.
     *
     * @param int $count
     * @param \stdClass $_links
     *
     * @return \Mollie\Api\Resources\BaseCollection
     */
    protected function getResourceCollectionObject($count, $_links)
    {
        return new SettlementCollection($this->client, $count, $_links);
    }

    /**
     * Retrieve a single settlement from Mollie.
     *
     * Will throw a ApiException if the settlement id is invalid or the resource cannot be found.
     *
     * @param string $settlementId
     * @param array $parameters
     * @return Settlement
     * @throws ApiException
     */
    public function get($settlementId, array $parameters = [])
    {
        return parent::rest_read($settlementId, $parameters);
    }

    /**
     * Retrieve the details of the current settlement that has not yet been paid out.
     *
     * @return Settlement
     * @throws ApiException
     */
    public function next()
    {
        return parent::rest_read("next", []);
    }

    /**
     * Retrieve the details of the open balance of the organization.
     *
     * @return Settlement
     * @throws ApiException
     */
    public function open()
    {
        return parent::rest_read("open", []);
    }

    /**
     * Retrieves a collection of Settlements from Mollie.
     *
     * @param string $from The first settlement ID you want to include in your list.
     * @param int $limit
     * @param array $parameters
     *
     * @return SettlementCollection
     * @throws ApiException
     */
    public function page($from = null, $limit = null, array $parameters = [])
    {
        return $this->rest_list($from, $limit, $parameters);
    }

    /**
     * Create an iterator for iterating over settlements retrieved from Mollie.
     *
     * @param string $from The first resource ID you want to include in your list.
     * @param int $limit
     * @param array $parameters
     * @param bool $iterateBackwards Set to true for reverse order iteration (default is false).
     *
     * @return LazyCollection
     */
    public function iterator(?string $from = null, ?int $limit = null, array $parameters = [], bool $iterateBackwards = false): LazyCollection
    {
        return $this->rest_iterator($from, $limit, $parameters, $iterateBackwards);
    }
}
