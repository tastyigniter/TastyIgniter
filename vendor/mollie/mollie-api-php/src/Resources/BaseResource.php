<?php

namespace Mollie\Api\Resources;

use Mollie\Api\MollieApiClient;

#[\AllowDynamicProperties]
abstract class BaseResource
{
    /**
     * @var MollieApiClient
     */
    protected $client;

    /**
     * Indicates the type of resource.
     *
     * @example payment
     *
     * @var string
     */
    public $resource;

    /**
     * @param MollieApiClient $client
     */
    public function __construct(MollieApiClient $client)
    {
        $this->client = $client;
    }
}
