<?php

namespace Mollie\Api\Endpoints;

use Mollie\Api\Resources\Payment;
use Mollie\Api\Resources\Route;
use Mollie\Api\Resources\RouteCollection;

class PaymentRouteEndpoint extends CollectionEndpointAbstract
{
    protected $resourcePath = "payments_routes";

    /**
     * Get the object that is used by this API endpoint. Every API endpoint uses one type of object.
     *
     * @return \Mollie\Api\Resources\Route
     */
    protected function getResourceObject()
    {
        return new Route($this->client);
    }

    /**
     * Get the collection object that is used by this API endpoint. Every API endpoint uses one type of collection object.
     *
     * @param int $count
     * @param \stdClass $_links
     *
     * @return \Mollie\Api\Resources\RouteCollection
     */
    protected function getResourceCollectionObject($count, $_links)
    {
        return new RouteCollection($this->client, $count, $_links);
    }

    /**
     * @param Payment $payment
     * @param string $routeId
     * @param string $releaseDate - UTC datetime in ISO-8601 format when the funds for the following payment will become available on
     * the balance of the connected account
     *
     * @return Route
     * @throws \Mollie\Api\Exceptions\ApiException
     */
    public function updateReleaseDateFor(Payment $payment, $routeId, $releaseDate)
    {
        return $this->updateReleaseDateForPaymentId($payment->id, $routeId, $releaseDate);
    }

    /**
     * @param string $paymentId
     * @param string $routeId
     * @param string $releaseDate - UTC datetime in ISO-8601 format when the funds for the following payment will become available on
     * the balance of the connected account
     *
     * @return \Mollie\Api\Resources\Route
     * @throws \Mollie\Api\Exceptions\ApiException
     */
    public function updateReleaseDateForPaymentId($paymentId, $routeId, $releaseDate, $testmode = false)
    {
        $this->parentId = $paymentId;

        $params = [
            'releaseDate' => $releaseDate,
            'testmode' => $testmode,
        ];

        return parent::rest_update($routeId, $params);
    }
}
