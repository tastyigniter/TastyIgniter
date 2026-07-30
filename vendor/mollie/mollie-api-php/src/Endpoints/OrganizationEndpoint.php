<?php

namespace Mollie\Api\Endpoints;

use Mollie\Api\Exceptions\ApiException;
use Mollie\Api\Resources\Organization;
use Mollie\Api\Resources\OrganizationCollection;

class OrganizationEndpoint extends CollectionEndpointAbstract
{
    protected $resourcePath = "organizations";

    /**
     * @return Organization
     */
    protected function getResourceObject()
    {
        return new Organization($this->client);
    }

    /**
     * Get the collection object that is used by this API endpoint. Every API endpoint uses one type of collection object.
     *
     * @param int $count
     * @param \stdClass $_links
     *
     * @return OrganizationCollection
     */
    protected function getResourceCollectionObject($count, $_links)
    {
        return new OrganizationCollection($this->client, $count, $_links);
    }

    /**
     * Retrieve an organization from Mollie.
     *
     * Will throw a ApiException if the organization id is invalid or the resource cannot be found.
     *
     * @param string $organizationId
     * @param array $parameters
     * @return Organization
     * @throws ApiException
     */
    public function get($organizationId, array $parameters = [])
    {
        if (empty($organizationId)) {
            throw new ApiException("Organization ID is empty.");
        }

        return parent::rest_read($organizationId, $parameters);
    }

    /**
     * Retrieve the current organization from Mollie.
     *
     * @param array $parameters
     * @return Organization
     * @throws ApiException
     */
    public function current(array $parameters = [])
    {
        return parent::rest_read('me', $parameters);
    }
}
