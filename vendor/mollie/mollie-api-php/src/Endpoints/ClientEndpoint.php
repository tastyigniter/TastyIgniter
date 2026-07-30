<?php

namespace Mollie\Api\Endpoints;

use Mollie\Api\Exceptions\ApiException;
use Mollie\Api\Resources\Client;
use Mollie\Api\Resources\ClientCollection;
use Mollie\Api\Resources\LazyCollection;

class ClientEndpoint extends CollectionEndpointAbstract
{
    protected $resourcePath = "clients";

    /**
     * @return Client
     */
    protected function getResourceObject()
    {
        return new Client($this->client);
    }

    /**
     * Get the collection object that is used by this API endpoint. Every API endpoint uses one type of collection object.
     *
     * @param int $count
     * @param \stdClass $_links
     *
     * @return ClientCollection
     */
    protected function getResourceCollectionObject($count, $_links)
    {
        return new ClientCollection($this->client, $count, $_links);
    }

    /**
     * Retrieve a client from Mollie.
     *
     * Will throw an ApiException if the client id is invalid or the resource cannot be found.
     * The client id corresponds to the organization id, for example "org_1337".
     *
     * @param string $clientId
     * @param array $parameters
     *
     * @return Client
     * @throws ApiException
     */
    public function get($clientId, array $parameters = [])
    {
        if (empty($clientId)) {
            throw new ApiException("Client ID is empty.");
        }

        return parent::rest_read($clientId, $parameters);
    }

    /**
     * Retrieves a page of clients from Mollie.
     *
     * @param string $from The first client ID you want to include in your list.
     * @param int $limit
     * @param array $parameters
     *
     * @return ClientCollection
     * @throws ApiException
     */
    public function page(?string $from = null, ?int $limit = null, array $parameters = [])
    {
        return $this->rest_list($from, $limit, $parameters);
    }

    /**
     * Create an iterator for iterating over clients retrieved from Mollie.
     *
     * @param string $from The first client ID you want to include in your list.
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
