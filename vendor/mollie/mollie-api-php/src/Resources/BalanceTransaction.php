<?php

declare(strict_types=1);

namespace Mollie\Api\Resources;

class BalanceTransaction extends BaseResource
{
    /**
     * Indicates this is a balance transaction resource. The value will always be "balance_transaction" here.
     *
     * @var string
     */
    public $resource;

    /**
     * The mode used to create this balance transaction. Mode determines whether real or test payments can be moved to
     * this balance. The value is either "live" or "test".
     *
     * @var string
     */
    public $mode;

    /**
     * The identifier uniquely referring this balance transaction. Mollie assigns this identifier at creation.
     *
     * @example baltr_QM24QwzUWR4ev4Xfgyt29d
     * @var string
     */
    public $id;

    /**
     * The type of movement, for example "payment" or "refund".
     *
     * @var string
     */
    public $type;

    /**
     * UTC datetime the balance transaction was created in ISO-8601 format.
     *
     * @example "2021-12-25T10:30:54+00:00"
     * @var string
     */
    public $createdAt;

    /**
     * The final amount that was moved to or from the balance. If the transaction moves funds away from the balance,
     * for example when it concerns a refund, the amount will be negative.
     *
     * @example {"currency":"EUR", "value":"100.00"}
     * @var \stdClass
     */
    public $resultAmount;

    /**
     * The amount that was to be moved to or from the balance, excluding deductions. If the transaction moves funds
     * away from the balance, for example when it concerns a refund, the amount will be negative.
     *
     * @var \stdClass
     */
    public $initialAmount;

    /**
     * The total amount of deductions withheld from the movement. For example, if a €10,00 payment comes in with a
     * €0,29 fee, the deductions amount will be {"currency":"EUR", "value":"-0.29"}. When moving funds to a balance,
     * we always round the deduction to a ‘real’ amount. Any differences between these realtime rounded amounts and
     * the final invoice will be compensated when the invoice is generated.
     *
     * @example {"currency":"EUR", "value":"-0.29"}
     *
     * @var \stdClass
     */
    public $deductions;

    /**
     * Depending on the type of the balance transaction, we will try to give more context about the specific event that
     * triggered the movement.
     *
     * @var \stdClass
     */
    public $context;
}
