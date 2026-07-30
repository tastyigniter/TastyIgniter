<?php

declare(strict_types=1);

namespace Mollie\Api\Endpoints;

use Mollie\Api\Resources\Balance;
use Mollie\Api\Resources\BalanceReport;
use Mollie\Api\Resources\ResourceFactory;

class BalanceReportEndpoint extends EndpointAbstract
{
    protected $resourcePath = "balances_report";

    /**
     * @inheritDoc
     */
    protected function getResourceObject()
    {
        return new BalanceReport($this->client);
    }

    /**
     * Retrieve a balance report for the provided balance id and parameters.
     *
     * @param string $balanceId
     * @param array $parameters
     * @return \Mollie\Api\Resources\BalanceReport|\Mollie\Api\Resources\BaseResource
     * @throws \Mollie\Api\Exceptions\ApiException
     */
    public function getForId(string $balanceId, array $parameters = [])
    {
        $this->parentId = $balanceId;

        $result = $this->client->performHttpCall(
            self::REST_READ,
            $this->getResourcePath() . $this->buildQueryString($parameters)
        );

        return ResourceFactory::createFromApiResult($result, $this->getResourceObject());
    }

    /**
     * Retrieve the primary balance.
     * This is the balance of your account’s primary currency, where all payments are settled to by default.
     *
     * @param array $parameters
     * @return \Mollie\Api\Resources\BalanceReport|\Mollie\Api\Resources\BaseResource
     * @throws \Mollie\Api\Exceptions\ApiException
     */
    public function getForPrimary(array $parameters = [])
    {
        return $this->getForId("primary", $parameters);
    }


    /**
     * Retrieve a balance report for the provided balance resource and parameters.
     *
     * @param \Mollie\Api\Resources\Balance $balance
     * @param array $parameters
     * @return \Mollie\Api\Resources\BalanceReport|\Mollie\Api\Resources\BaseResource
     * @throws \Mollie\Api\Exceptions\ApiException
     */
    public function getFor(Balance $balance, array $parameters = [])
    {
        return $this->getForId($balance->id, $parameters);
    }
}
