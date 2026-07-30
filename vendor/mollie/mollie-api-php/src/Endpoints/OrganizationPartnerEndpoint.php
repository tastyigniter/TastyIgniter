<?php

namespace Mollie\Api\Endpoints;

use Mollie\Api\Exceptions\ApiException;
use Mollie\Api\Resources\BaseResource;
use Mollie\Api\Resources\Partner;
use Mollie\Api\Resources\ResourceFactory;

class OrganizationPartnerEndpoint extends EndpointAbstract
{
    protected $resourcePath = "organizations/me/partner";

    protected function getResourceCollectionObject($count, $links)
    {
        throw new \BadMethodCallException('not implemented');
    }

    /**
     * Get the object that is used by this API endpoint. Every API endpoint uses one type of object.
     *
     * @return BaseResource
     */
    protected function getResourceObject()
    {
        return new Partner($this->client);
    }

    /**
     * Retrieve details about the partner status of the currently authenticated organization.
     *
     * Will throw an ApiException if the resource cannot be found.
     *
     * @return Partner
     * @throws ApiException
     */
    public function get()
    {
        return $this->rest_read('', []);
    }

    /**
     * @param string $id
     * @param array $filters
     *
     * @return mixed
     * @throws \Mollie\Api\Exceptions\ApiException
     */
    protected function rest_read($id, array $filters)
    {
        $result = $this->client->performHttpCall(
            self::REST_READ,
            $this->getResourcePath() . $this->buildQueryString($filters)
        );

        return ResourceFactory::createFromApiResult($result, $this->getResourceObject());
    }
}
