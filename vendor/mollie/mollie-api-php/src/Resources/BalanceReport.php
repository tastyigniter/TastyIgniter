<?php

declare(strict_types=1);

namespace Mollie\Api\Resources;

class BalanceReport extends BaseResource
{
    /**
     * Indicates the response contains a balance report object. Will always contain "balance-report" for this endpoint.
     *
     * @var string
     */
    public $resource;

    /**
     * The ID of the balance this report was generated for.
     *
     * @example bal_gVMhHKqSSRYJyPsuoPNFH
     * @var string
     */
    public $balanceId;

    /**
     * The time zone used for the "from" and "until" parameters.
     * Currently only time zone "Europe/Amsterdam" is supported.
     *
     *
     * @example Europe/Amsterdam
     * @var string
     */
    public $timeZone;

    /**
     * The start date of the report, in YYYY-MM-DD format. The "from" date is ‘inclusive’, and in Central European Time.
     * This means a report with for example "from: 2020-01-01" will include movements of "2020-01-01 0:00:00 CET" and
     * onwards.
     *
     *
     * @example 2020-01-01
     * @var string
     */
    public $from;

    /**
     * The end date of the report, in YYYY-MM-DD format. The "until" date is ‘exclusive’, and in Central European Time.
     * This means a report with for example "until: 2020-02-01" will include movements up
     * until "2020-01-31 23:59:59 CET".
     *
     * @var string
     */
    public $until;

    /**
     * You can retrieve reports in two different formats: "status-balances" or "transaction-categories".
     * With the "status-balances" format, transactions are grouped by status (e.g. "pending", "available"), then by
     * direction of movement (e.g. moved from "pending" to "available"), then by transaction type, and then by other
     * sub-groupings where available (e.g. payment method).
     * With the "transaction-categories" format, transactions are grouped by transaction type, then by direction of
     * movement, and then again by other sub-groupings where available. Both reporting formats will always contain
     * opening and closing amounts that correspond to the start and end dates of the report.
     *
     * @var string
     */
    public $grouping;

    /**
     * The balance report totals, structured according to the defined "grouping".
     *
     * @var \stdClass
     */
    public $totals;

    /**
     * Links to help navigate through the API.
     *
     * @var \stdClass
     */
    public $_links;
}
