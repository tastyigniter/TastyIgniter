<?php

namespace Mollie\Api\Endpoints;

use Mollie\Api\Exceptions\ApiException;
use Mollie\Api\Resources\LazyCollection;
use Mollie\Api\Resources\Session;
use Mollie\Api\Resources\SessionCollection;

class SessionEndpoint extends CollectionEndpointAbstract
{
    protected $resourcePath = "sessions";

    /**
     * @var string
     */
    public const RESOURCE_ID_PREFIX = 'sess_';

    /**
     * Get the object that is used by this API endpoint. Every API endpoint uses one
     * type of object.
     *
     * @return Session
     */
    protected function getResourceObject()
    {
        return new Session($this->client);
    }

    /**
     * Get the collection object that is used by this API endpoint. Every API
     * endpoint uses one type of collection object.
     *
     * @param int $count
     * @param \stdClass $_links
     *
     * @return SessionCollection
     */
    protected function getResourceCollectionObject($count, $_links)
    {
        return new SessionCollection($this->client, $count, $_links);
    }

    /**
     * Creates a session in Mollie.
     *
     * @param array $data An array containing details on the session.
     * @param array $filters
     *
     * @return Session
     * @throws ApiException
     */
    public function create(array $data = [], array $filters = [])
    {
        return $this->rest_create($data, $filters);
    }

    /**
     * Update a specific Session resource
     *
     * Will throw a ApiException if the resource id is invalid or the resource cannot be found.
     *
     * @param string $resourceId
     *
     * @param array $data
     * @return Session
     * @throws ApiException
     */
    public function update($resourceId, array $data = [])
    {
        if (empty($resourceId) || strpos($resourceId, self::RESOURCE_ID_PREFIX) !== 0) {
            throw new ApiException("Invalid session ID: '{$resourceId}'. A session ID should start with '" . self::RESOURCE_ID_PREFIX . "'.");
        }

        return parent::rest_update($resourceId, $data);
    }

    /**
     * Retrieve a single session from Mollie.
     *
     * Will throw a ApiException if the resource id is invalid or the resource cannot
     * be found.
     *
     * @param array $parameters
     * @return Session
     * @throws ApiException
     */
    public function get($resourceId, array $parameters = [])
    {
        if (empty($resourceId) || strpos($resourceId, self::RESOURCE_ID_PREFIX) !== 0) {
            throw new ApiException("Invalid session ID: '{$resourceId}'. A session ID should start with '" . self::RESOURCE_ID_PREFIX . "'.");
        }

        return parent::rest_read($resourceId, $parameters);
    }

    /**
     * Cancel the given Session.
     *
     * @param string $resourceId
     * @param array $parameters
     * @return Session
     * @throws ApiException
     */
    public function cancel($resourceId, $parameters = [])
    {
        return $this->rest_delete($resourceId, $parameters);
    }

    /**
     * Retrieves a collection of Sessions from Mollie.
     *
     * @param string $from The first resource ID you want to include in your list.
     * @param int $limit
     * @param array $parameters
     *
     * @return SessionCollection
     * @throws ApiException
     */
    public function page(?string $from = null, ?int $limit = null, array $parameters = [])
    {
        return $this->rest_list($from, $limit, $parameters);
    }

    /**
     * Create an iterator for iterating over sessions retrieved from Mollie.
     *
     * @param string $from The first resource ID you want to include in your list.
     * @param int $limit
     * @param array $parameters
     * @param bool $iterateBackwards Set to true for reverse resource iteration (default is false).
     *
     * @return LazyCollection
     */
    public function iterator(?string $from = null, ?int $limit = null, array $parameters = [], bool $iterateBackwards = false): LazyCollection
    {
        return $this->rest_iterator($from, $limit, $parameters, $iterateBackwards);
    }
}
