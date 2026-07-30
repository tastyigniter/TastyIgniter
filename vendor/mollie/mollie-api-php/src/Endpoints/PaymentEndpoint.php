<?php

namespace Mollie\Api\Endpoints;

use Mollie\Api\Exceptions\ApiException;
use Mollie\Api\Resources\LazyCollection;
use Mollie\Api\Resources\Payment;
use Mollie\Api\Resources\PaymentCollection;
use Mollie\Api\Resources\Refund;
use Mollie\Api\Resources\ResourceFactory;

class PaymentEndpoint extends CollectionEndpointAbstract
{
    protected $resourcePath = "payments";

    /**
     * @var string
     */
    public const RESOURCE_ID_PREFIX = 'tr_';

    /**
     * @return Payment
     */
    protected function getResourceObject()
    {
        return new Payment($this->client);
    }

    /**
     * Get the collection object that is used by this API endpoint. Every API endpoint uses one type of collection object.
     *
     * @param int $count
     * @param \stdClass $_links
     *
     * @return PaymentCollection
     */
    protected function getResourceCollectionObject($count, $_links)
    {
        return new PaymentCollection($this->client, $count, $_links);
    }

    /**
     * Creates a payment in Mollie.
     *
     * @param array $data An array containing details on the payment.
     * @param array $filters
     *
     * @return Payment
     * @throws ApiException
     */
    public function create(array $data = [], array $filters = [])
    {
        return $this->rest_create($data, $filters);
    }

    /**
     * Update the given Payment.
     *
     * Will throw a ApiException if the payment id is invalid or the resource cannot be found.
     *
     * @param string $paymentId
     *
     * @param array $data
     * @return Payment
     * @throws ApiException
     */
    public function update($paymentId, array $data = [])
    {
        if (empty($paymentId) || strpos($paymentId, self::RESOURCE_ID_PREFIX) !== 0) {
            throw new ApiException("Invalid payment ID: '{$paymentId}'. A payment ID should start with '" . self::RESOURCE_ID_PREFIX . "'.");
        }

        return parent::rest_update($paymentId, $data);
    }

    /**
     * Retrieve a single payment from Mollie.
     *
     * Will throw a ApiException if the payment id is invalid or the resource cannot be found.
     *
     * @param string $paymentId
     * @param array $parameters
     * @return Payment
     * @throws ApiException
     */
    public function get($paymentId, array $parameters = [])
    {
        if (empty($paymentId) || strpos($paymentId, self::RESOURCE_ID_PREFIX) !== 0) {
            throw new ApiException("Invalid payment ID: '{$paymentId}'. A payment ID should start with '" . self::RESOURCE_ID_PREFIX . "'.");
        }

        return parent::rest_read($paymentId, $parameters);
    }

    /**
     * Deletes the given Payment.
     *
     * Will throw a ApiException if the payment id is invalid or the resource cannot be found.
     * Returns with HTTP status No Content (204) if successful.
     *
     * @param string $paymentId
     *
     * @param array $data
     * @return Payment
     * @throws ApiException
     */
    public function delete($paymentId, array $data = [])
    {
        return $this->rest_delete($paymentId, $data);
    }

    /**
     * Cancel the given Payment. This is just an alias of the 'delete' method.
     *
     * Will throw a ApiException if the payment id is invalid or the resource cannot be found.
     * Returns with HTTP status No Content (204) if successful.
     *
     * @param string $paymentId
     *
     * @param array $data
     * @return Payment
     * @throws ApiException
     */
    public function cancel($paymentId, array $data = [])
    {
        return $this->rest_delete($paymentId, $data);
    }

    /**
     * Retrieves a collection of Payments from Mollie.
     *
     * @param string $from The first payment ID you want to include in your list.
     * @param int $limit
     * @param array $parameters
     *
     * @return PaymentCollection
     * @throws ApiException
     */
    public function page($from = null, $limit = null, array $parameters = [])
    {
        return $this->rest_list($from, $limit, $parameters);
    }

    /**
     * Create an iterator for iterating over payments retrieved from Mollie.
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

    /**
     * Issue a refund for the given payment.
     *
     * The $data parameter may either be an array of endpoint parameters, a float value to
     * initiate a partial refund, or empty to do a full refund.
     *
     * @param Payment $payment
     * @param array|float|null $data
     *
     * @return Refund
     * @throws ApiException
     */
    public function refund(Payment $payment, $data = [])
    {
        $resource = "{$this->getResourcePath()}/" . urlencode($payment->id) . "/refunds";

        $body = null;
        if (($data === null ? 0 : count($data)) > 0) {
            $body = json_encode($data);
        }

        $result = $this->client->performHttpCall(self::REST_CREATE, $resource, $body);

        return ResourceFactory::createFromApiResult($result, new Refund($this->client));
    }

    /**
     * Release the authorization for the given payment.
     *
     * @param Payment|string $paymentId
     *
     * @return void
     * @throws ApiException
     */
    public function releaseAuthorization($paymentId): void
    {
        $paymentId = $paymentId instanceof Payment ? $paymentId->id : $paymentId;

        $resource = "{$this->getResourcePath()}/" . urlencode($paymentId) . "/release-authorization";

        $this->client->performHttpCall(self::REST_CREATE, $resource);
    }
}
