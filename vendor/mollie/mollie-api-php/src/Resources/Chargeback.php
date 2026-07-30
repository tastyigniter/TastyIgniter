<?php

namespace Mollie\Api\Resources;

class Chargeback extends BaseResource
{
    /**
     * Always 'chargeback'.
     *
     * @var string
     */
    public $resource;

    /**
     * Id of the payment method.
     *
     * @var string
     */
    public $id;

    /**
     * The $amount that was refunded.
     *
     * @var \stdClass
     */
    public $amount;

    /**
     * UTC datetime the payment was created in ISO-8601 format.
     *
     * @example "2013-12-25T10:30:54+00:00"
     * @var string|null
     */
    public $createdAt;

    /**
     * The payment id that was refunded.
     *
     * @var string
     */
    public $paymentId;

    /**
     * The settlement amount.
     *
     * @var \stdClass
     */
    public $settlementAmount;

    /**
     * The identifier referring to the settlement this payment was settled with.
     *
     * @var string|null
     */
    public $settlementId;

    /**
     * The chargeback reason
     *
     * @var \stdClass|null
     */
    public $reason;

    /**
     * UTC datetime the date and time the chargeback was reversed in ISO-8601 format.
     *
     * @example "2013-12-25T10:30:54+00:00"
     * @var string|null
     */
    public $reversedAt;

    /**
     * @var \stdClass
     */
    public $_links;
}
