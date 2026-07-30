<?php

namespace Mollie\Api\Resources;

class Balance extends BaseResource
{
    /**
     * Indicates this is a balance resource. The value will always be "balance" here.
     *
     * @var string
     */
    public $resource;

    /**
     * The mode used to create this balance. Mode determines whether real or test payments can be moved to this balance.
     * The value is either "live" or "test".
     *
     * @var string
     */
    public $mode;

    /**
     * The identifier uniquely referring this balance. Mollie assigns this identifier at balance creation.
     *
     * @example bal_gVMhHKqSSRYJyPsuoPABC
     * @var string
     */
    public $id;

    /**
     * UTC datetime the balance was created in ISO-8601 format.
     *
     * @example "2021-12-25T10:30:54+00:00"
     * @var string
     */
    public $createdAt;

    /**
     * The balance's ISO 4217 currency code.
     *
     * @var string
     */
    public $currency;

    /**
     * The status of the balance: "active" if the balance is operational and ready to be used.
     * The status is "inactive" if the account is still being validated by Mollie or if the balance has been blocked.
     *
     * @var string
     */
    public $status;

    /**
     * The total amount directly available on the balance.
     *
     * @var \stdClass
     */
    public $availableAmount;

    /**
     * The total amount queued to be transferred to your balance.
     * For example, a credit card payment can take a few days to clear.
     *
     * @var \stdClass
     */
    public $incomingAmount;

    /**
     * The total amount that is in the process of being transferred from your balance to your verified bank account.
     * @var \stdClass
     */
    public $outgoingAmount;

    /**
     * The frequency at which the available amount on the balance will be transferred away to the configured transfer
     * destination. See "transferDestination". Note that if the transfer is for an external destination, and the
     * transfer is created in a weekend or during a bank holiday, the actual bank transfer will take place on the next
     * business day.
     *
     * @var string
     */
    public $transferFrequency;

    /**
     * The minimum amount configured for scheduled automatic balance transfers. As soon as the amount on the balance
     * exceeds this threshold, the complete balance will be paid out to the "transferDestination" according to the
     * configured "transferFrequency".
     *
     * @var \stdClass
     */
    public $transferThreshold;

    /**
     * The reference to be included on all transfers for this balance.
     *
     * @var string|null
     */
    public $transferReference;

    /**
     * The destination where the available amount will be automatically transferred to according to the configured
     * "transferFrequency".
     *
     * @var \stdClass
     */
    public $transferDestination;

    /**
     * Links to help navigate through the Mollie API and related resources.
     *
     * @var \stdClass
     */
    public $_links;
}
