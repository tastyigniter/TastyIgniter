<?php

namespace Mollie\Api\Endpoints;

use Mollie\Api\Exceptions\ApiException;
use Mollie\Api\Resources\ClientLink;

class ClientLinkEndpoint extends EndpointAbstract
{
    protected $resourcePath = "client-links";

    /**
     * @var string
     */
    public const RESOURCE_ID_PREFIX = 'cl_';

    /**
     * Get the object that is used by this API endpoint. Every API endpoint uses one
     * type of object.
     *
     * @return ClientLink
     */
    protected function getResourceObject(): ClientLink
    {
        return new ClientLink($this->client);
    }

    /**
     * Creates a client link in Mollie.
     *
     * @param array $data An array containing details on the client link.
     *
     * @return ClientLink
     * @throws ApiException
     */
    public function create(array $data = []): ClientLink
    {
        return $this->rest_create($data, []);
    }
}
