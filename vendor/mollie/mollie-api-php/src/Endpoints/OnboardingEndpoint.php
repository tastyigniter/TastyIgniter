<?php

namespace Mollie\Api\Endpoints;

use Mollie\Api\Exceptions\ApiException;
use Mollie\Api\Resources\BaseResource;
use Mollie\Api\Resources\Onboarding;
use Mollie\Api\Resources\ResourceFactory;

class OnboardingEndpoint extends EndpointAbstract
{
    protected $resourcePath = "onboarding/me";

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
        return new Onboarding($this->client);
    }

    /**
     * Retrieve the organization's onboarding status from Mollie.
     *
     * Will throw a ApiException if the resource cannot be found.
     *
     * @return Onboarding
     * @throws ApiException
     */
    public function get()
    {
        return $this->rest_read('', []);
    }

    /**
     * @deprecated 2023-05-01 For an alternative, see https://docs.mollie.com/reference/create-client-link .
     * Submit data that will be prefilled in the merchant’s onboarding.
     * Please note that the data you submit will only be processed when the onboarding status is needs-data.
     *
     * Information that the merchant has entered in their dashboard will not be overwritten.
     *
     * Will throw an ApiException if the resource cannot be found.
     * @throws ApiException
     */
    public function submit(array $parameters = [])
    {
        return $this->rest_create($parameters, []);
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

    /**
     * @param array $body
     * @param array $filters
     *
     * @return mixed
     * @throws \Mollie\Api\Exceptions\ApiException
     */
    protected function rest_create(array $body, array $filters)
    {
        $this->client->performHttpCall(
            self::REST_CREATE,
            $this->getResourcePath() . $this->buildQueryString($filters),
            $this->parseRequestBody($body)
        );
    }
}
