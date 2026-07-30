<?php

namespace Mollie\Api\Resources;

use Mollie\Api\Types\SalesInvoiceStatus;

class SalesInvoice extends BaseResource
{
    /**
     * @var string
     */
    public $resource;

    /**
     * @var string
     */
    public $id;

    /**
     * @var string|null
     */
    public $profileId;

    /**
     * @var string|null
     */
    public $invoiceNumber;

    /**
     * @var string
     */
    public $currency;

    /**
     * @var string
     */
    public $status;

    /**
     * @var string
     */
    public $vatScheme;

    /**
     * @var string
     */
    public $vatMode;

    /**
     * @var string|null
     */
    public $memo;

    /**
     * @var string
     */
    public $paymentTerm;

    /**
     * @var object
     */
    public $paymentDetails;
    /**
     * @var object
     */
    public $emailDetails;

    /**
     * @var string
     */
    public $recipientIdentifier;

    /**
     * @var object
     */
    public $recipient;

    /**
     * @var array
     */
    public $lines;

    /**
     * @var string
     */
    public $webhookUrl;

    /**
     * @var object|null
     */
    public $discount;

    /**
     * @var object
     */
    public $amountDue;

    /**
     * @var object
     */
    public $subtotalAmount;

    /**
     * @var object
     */
    public $totalAmount;

    /**
     * @var object
     */
    public $totalVatAmount;

    /**
     * @var object
     */
    public $discountedSubtotalAmount;

    /**
     * @var string
     */
    public $createdAt;

    /**
     * @var string|null
     */
    public $issuedAt;

    /**
     * @var string|null
     */
    public $dueAt;

    /**
     * @var object
     */
    public $_links;

    /**
     * Returns whether the sales invoice is in draft status.
     *
     * @return bool
     */
    public function isDraft()
    {
        return $this->status === SalesInvoiceStatus::DRAFT;
    }

    /**
     * Returns whether the sales invoice is issued.
     *
     * @return bool
     */
    public function isIssued()
    {
        return $this->status === SalesInvoiceStatus::ISSUED;
    }

    /**
     * Returns whether the sales invoice is paid.
     *
     * @return bool
     */
    public function isPaid()
    {
        return $this->status === SalesInvoiceStatus::PAID;
    }
}
