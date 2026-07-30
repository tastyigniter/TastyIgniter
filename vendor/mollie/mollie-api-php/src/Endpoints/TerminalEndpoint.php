<?php

namespace Mollie\Api\Endpoints;

use Mollie\Api\Exceptions\ApiException;
use Mollie\Api\Resources\LazyCollection;
use Mollie\Api\Resources\Terminal;
use Mollie\Api\Resources\TerminalCollection;

class TerminalEndpoint extends CollectionEndpointAbstract
{
    protected $resourcePath = "terminals";

    /**
     * @var string
     */
    public const RESOURCE_ID_PREFIX = 'term_';

    /**
     * @return Terminal
     */
    protected function getResourceObject()
    {
        return new Terminal($this->client);
    }

    /**
     * Get the collection object that is used by this API endpoint. Every API endpoint uses one type of collection object.
     *
     * @param int $count
     * @param \stdClass $_links
     *
     * @return TerminalCollection
     */
    protected function getResourceCollectionObject($count, $_links)
    {
        return new TerminalCollection($this->client, $count, $_links);
    }

    /**
     * Retrieve terminal from Mollie.
     *
     * Will throw a ApiException if the terminal id is invalid or the resource cannot be found.
     *
     * @param string $terminalId
     * @param array $parameters
     * @return Terminal
     * @throws ApiException
     */
    public function get($terminalId, array $parameters = [])
    {
        if (empty($terminalId) || strpos($terminalId, self::RESOURCE_ID_PREFIX) !== 0) {
            throw new ApiException("Invalid terminal ID: '{$terminalId}'. A terminal ID should start with '" . self::RESOURCE_ID_PREFIX . "'.");
        }

        return parent::rest_read($terminalId, $parameters);
    }

    /**
     * Retrieves a collection of Terminals from Mollie for the current organization / profile, ordered from newest to oldest.
     *
     * @param string $from The first terminal ID you want to include in your list.
     * @param int $limit
     * @param array $parameters
     *
     * @return TerminalCollection
     * @throws ApiException
     */
    public function page($from = null, $limit = null, array $parameters = [])
    {
        return $this->rest_list($from, $limit, $parameters);
    }

    /**
     * Create an iterator for iterating over terminals retrieved from Mollie.
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
