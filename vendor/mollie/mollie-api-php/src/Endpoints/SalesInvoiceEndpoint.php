<?php

namespace Mollie\Api\Endpoints;

use Mollie\Api\Exceptions\ApiException;
use Mollie\Api\Resources\LazyCollection;
use Mollie\Api\Resources\SalesInvoice;
use Mollie\Api\Resources\SalesInvoiceCollection;

class SalesInvoiceEndpoint extends CollectionEndpointAbstract
{
    protected $resourcePath = "sales-invoices";

    /**
     * @var string
     */
    public const RESOURCE_ID_PREFIX = 'invoice_';

    /**
     * @return SalesInvoice
     */
    protected function getResourceObject(): SalesInvoice
    {
        return new SalesInvoice($this->client);
    }

    /**
     * Get the collection object that is used by this API endpoint. Every API endpoint uses one type of collection object.
     *
     * @param int $count
     * @param \stdClass $_links
     *
     * @return SalesInvoiceCollection
     */
    protected function getResourceCollectionObject($count, $_links): SalesInvoiceCollection
    {
        return new SalesInvoiceCollection($this->client, $count, $_links);
    }

    /**
     * Creates a payment in Mollie.
     *
     * @param array $data An array containing details on the payment.
     *
     * @return SalesInvoice
     * @throws ApiException
     */
    public function create(array $data = []): SalesInvoice
    {
        return $this->rest_create($data, []);
    }

    /**
     * Update the given Payment.
     *
     * Will throw a ApiException if the payment id is invalid or the resource cannot be found.
     *
     * @param string $salesInvoiceId
     *
     * @param array $data
     * @return SalesInvoice
     * @throws ApiException
     */
    public function update($salesInvoiceId, array $data = []): SalesInvoice
    {
        if (empty($salesInvoiceId) || strpos($salesInvoiceId, self::RESOURCE_ID_PREFIX) !== 0) {
            throw new ApiException("Invalid sales invoice ID: '{$salesInvoiceId}'. A sales invoice ID should start with '" . self::RESOURCE_ID_PREFIX . "'.");
        }

        return parent::rest_update($salesInvoiceId, $data);
    }

    /**
     * @param string $salesInvoiceId
     * @param array $parameters
     * @return SalesInvoice
     * @throws ApiException
     */
    public function get($salesInvoiceId, array $parameters = []): SalesInvoice
    {
        if (empty($salesInvoiceId) || strpos($salesInvoiceId, self::RESOURCE_ID_PREFIX) !== 0) {
            throw new ApiException("Invalid sales invoice ID: '{$salesInvoiceId}'. A sales invoice ID should start with '" . self::RESOURCE_ID_PREFIX . "'.");
        }

        return parent::rest_read($salesInvoiceId, $parameters);
    }

    /**
     * @param string $salesInvoiceId
     *
     * @param array $data
     * @throws ApiException
     */
    public function delete($salesInvoiceId, array $data = []): void
    {
        $this->rest_delete($salesInvoiceId, $data);
    }

    /**
     * @param string $from The first payment ID you want to include in your list.
     * @param int $limit
     *
     * @return SalesInvoiceCollection
     * @throws ApiException
     */
    public function page($from = null, $limit = null)
    {
        return $this->rest_list($from, $limit, []);
    }

    /**
     * @param string $from The first resource ID you want to include in your list.
     * @param int $limit
     * @param bool $iterateBackwards Set to true for reverse order iteration (default is false).
     *
     * @return LazyCollection
     */
    public function iterator(?string $from = null, ?int $limit = null, bool $iterateBackwards = false): LazyCollection
    {
        return $this->rest_iterator($from, $limit, [], $iterateBackwards);
    }
}
