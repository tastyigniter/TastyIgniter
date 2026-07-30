<?php

namespace Mollie\Api\Endpoints;

use Mollie\Api\Exceptions\ApiException;
use Mollie\Api\Resources\Invoice;
use Mollie\Api\Resources\InvoiceCollection;
use Mollie\Api\Resources\LazyCollection;

class InvoiceEndpoint extends CollectionEndpointAbstract
{
    protected $resourcePath = "invoices";

    /**
     * Get the object that is used by this API. Every API uses one type of object.
     *
     * @return \Mollie\Api\Resources\BaseResource
     */
    protected function getResourceObject()
    {
        return new Invoice($this->client);
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
        return new InvoiceCollection($this->client, $count, $_links);
    }

    /**
     * Retrieve an Invoice from Mollie.
     *
     * Will throw a ApiException if the invoice id is invalid or the resource cannot be found.
     *
     * @param string $invoiceId
     * @param array $parameters
     *
     * @return Invoice
     * @throws ApiException
     */
    public function get($invoiceId, array $parameters = [])
    {
        return $this->rest_read($invoiceId, $parameters);
    }

    /**
     * Retrieves a collection of Invoices from Mollie.
     *
     * @param string $from The first invoice ID you want to include in your list.
     * @param int $limit
     * @param array $parameters
     *
     * @return InvoiceCollection
     * @throws ApiException
     */
    public function page($from = null, $limit = null, array $parameters = [])
    {
        return $this->rest_list($from, $limit, $parameters);
    }

    /**
     * This is a wrapper method for page
     *
     * @param array $parameters
     *
     * @return \Mollie\Api\Resources\BaseCollection
     * @throws ApiException
     */
    public function all(array $parameters = [])
    {
        return $this->page(null, null, $parameters);
    }

    /**
     * Create an iterator for iterating over invoices retrieved from Mollie.
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
