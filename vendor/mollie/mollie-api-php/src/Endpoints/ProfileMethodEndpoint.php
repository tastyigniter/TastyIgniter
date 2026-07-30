<?php

namespace Mollie\Api\Endpoints;

use Mollie\Api\Resources\Method;
use Mollie\Api\Resources\MethodCollection;
use Mollie\Api\Resources\Profile;
use Mollie\Api\Resources\ResourceFactory;

class ProfileMethodEndpoint extends CollectionEndpointAbstract
{
    protected $resourcePath = "profiles_methods";

    /**
     * Get the object that is used by this API endpoint. Every API endpoint uses one type of object.
     *
     * @return Method
     */
    protected function getResourceObject()
    {
        return new Method($this->client);
    }

    /**
     * Get the collection object that is used by this API endpoint. Every API endpoint uses one type of collection object.
     *
     * @param int $count
     * @param \stdClass $_links
     *
     * @return MethodCollection()
     */
    protected function getResourceCollectionObject($count, $_links)
    {
        return new MethodCollection($count, $_links);
    }

    /**
     * Enable a method for the provided Profile ID.
     *
     * @param string $profileId
     * @param string $methodId
     * @param array $data
     * @return \Mollie\Api\Resources\Method
     * @throws \Mollie\Api\Exceptions\ApiException
     */
    public function createForId($profileId, $methodId, array $data = [])
    {
        $this->parentId = $profileId;
        $resource = $this->getResourcePath() . '/' . urlencode($methodId);

        $body = null;
        if (count($data) > 0) {
            $body = json_encode($data);
        }

        $result = $this->client->performHttpCall(self::REST_CREATE, $resource, $body);

        return ResourceFactory::createFromApiResult($result, new Method($this->client));
    }

    /**
     * Enable a method for the provided Profile object.
     *
     * @param Profile $profile
     * @param string $methodId
     * @param array $data
     * @return Method
     * @throws \Mollie\Api\Exceptions\ApiException
     */
    public function createFor($profile, $methodId, array $data = [])
    {
        return $this->createForId($profile->id, $methodId, $data);
    }

    /**
     * Enable a method for the current profile.
     *
     * @param string $methodId
     * @param array $data
     * @return \Mollie\Api\Resources\Method
     * @throws \Mollie\Api\Exceptions\ApiException
     */
    public function createForCurrentProfile($methodId, array $data = [])
    {
        return $this->createForId('me', $methodId, $data);
    }

    /**
     * Disable a method for the provided Profile ID.
     *
     * @param string $profileId
     * @param string $methodId
     * @param array $data
     * @return mixed
     * @throws \Mollie\Api\Exceptions\ApiException
     */
    public function deleteForId($profileId, $methodId, array $data = [])
    {
        $this->parentId = $profileId;

        return $this->rest_delete($methodId, $data);
    }

    /**
     * Disable a method for the provided Profile object.
     *
     * @param Profile $profile
     * @param string $methodId
     * @param array $data
     * @throws \Mollie\Api\Exceptions\ApiException
     */
    public function deleteFor($profile, $methodId, array $data = [])
    {
        return $this->deleteForId($profile->id, $methodId, $data);
    }

    /**
     * Disable a method for the current profile.
     *
     * @param string $methodId
     * @param array $data
     * @return \Mollie\Api\Resources\Method
     * @throws \Mollie\Api\Exceptions\ApiException
     */
    public function deleteForCurrentProfile($methodId, array $data)
    {
        return $this->deleteForId('me', $methodId, $data);
    }
}
