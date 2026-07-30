<?php

namespace Mollie\Api\Resources;

use Mollie\Api\Exceptions\ApiException;
use Mollie\Api\Types\SettlementStatus;

class Settlement extends BaseResource
{
    /**
     * Id of the settlement.
     *
     * @var string
     */
    public $id;

    /**
     * The settlement reference. This corresponds to an invoice that's in your Dashboard.
     *
     * @var string
     */
    public $reference;

    /**
     * UTC datetime the payment was created in ISO-8601 format.
     *
     * @example "2013-12-25T10:30:54+00:00"
     * @var string
     */
    public $createdAt;

    /**
     * The date on which the settlement was settled, in ISO 8601 format. When requesting the open settlement or next settlement the return value is null.
     *
     * @example "2013-12-25T10:30:54+00:00"
     * @var string|null
     */
    public $settledAt;

    /**
     * Status of the settlement.
     *
     * @var string
     */
    public $status;

    /**
     * Total settlement amount in euros.
     *
     * @var \stdClass
     */
    public $amount;

    /**
     * Revenues and costs nested per year, per month, and per payment method.
     *
     * @var \stdClass
     */
    public $periods;

    /**
     * The ID of the invoice on which this settlement is invoiced, if it has been invoiced.
     *
     * @var string|null
     */
    public $invoiceId;

    /**
     * @var \stdClass
     */
    public $_links;

    /**
     * Is this settlement still open?
     *
     * @return bool
     */
    public function isOpen()
    {
        return $this->status === SettlementStatus::STATUS_OPEN;
    }

    /**
     * Is this settlement pending?
     *
     * @return bool
     */
    public function isPending()
    {
        return $this->status === SettlementStatus::STATUS_PENDING;
    }

    /**
     * Is this settlement paid out?
     *
     * @return bool
     */
    public function isPaidout()
    {
        return $this->status === SettlementStatus::STATUS_PAIDOUT;
    }

    /**
     * Has this settlement failed?
     *
     * @return bool
     */
    public function isFailed()
    {
        return $this->status === SettlementStatus::STATUS_FAILED;
    }

    /**
     * Retrieve the first page of payments associated with this settlement.
     *
     * @param int|null $limit
     * @param array $parameters
     * @return PaymentCollection
     * @throws \Mollie\Api\Exceptions\ApiException
     */
    public function payments(?int $limit = null, array $parameters = []): PaymentCollection
    {
        return $this->client->settlementPayments->pageForId(
            $this->id,
            null,
            $limit,
            $parameters
        );
    }

    /**
     * Retrieve the first page of refunds associated with this settlement.
     *
     * @param int|null $limit
     * @param array $parameters
     * @return RefundCollection
     * @throws ApiException
     */
    public function refunds(?int $limit = null, array $parameters = [])
    {
        return $this->client->settlementRefunds->pageForId(
            $this->id,
            null,
            $limit,
            $parameters
        );
    }

    /**
     * Retrieve the first page of chargebacks associated with this settlement.
     *
     * @param int|null $limit
     * @param array $parameters
     * @return ChargebackCollection
     * @throws ApiException
     */
    public function chargebacks(?int $limit = null, array $parameters = [])
    {
        return $this->client->settlementChargebacks->pageForId(
            $this->id,
            null,
            $limit,
            $parameters
        );
    }

    /**
     * Retrieve the first page of cap associated with this settlement.
     *
     * @param int|null $limit
     * @param array $parameters
     * @return CaptureCollection
     * @throws ApiException
     */
    public function captures(?int $limit = null, array $parameters = [])
    {
        return $this->client->settlementCaptures->pageForId(
            $this->id,
            null,
            $limit,
            $parameters
        );
    }
}
