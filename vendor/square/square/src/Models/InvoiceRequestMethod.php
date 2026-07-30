<?php

declare(strict_types=1);

namespace Square\Models;

/**
 * Specifies the action for Square to take for processing the invoice. For example,
 * email the invoice, charge a customer's card on file, or do nothing. DEPRECATED at
 * version 2021-01-21. The corresponding `request_method` field is replaced by the
 * `Invoice.delivery_method` and `InvoicePaymentRequest.automatic_payment_source` fields.
 */
class InvoiceRequestMethod
{
    /**
     * Directs Square to send invoices, reminders, and receipts to the customer using email.
     * Square sends the invoice after it is published (either immediately or at the `scheduled_at`
     * time, if specified in the [invoice](entity:Invoice)).
     */
    public const EMAIL = 'EMAIL';

    /**
     * Directs Square to charge the card on file on the `due_date` specified in the payment request
     * and to use email to send invoices, reminders, and receipts.
     */
    public const CHARGE_CARD_ON_FILE = 'CHARGE_CARD_ON_FILE';

    /**
     * Directs Square to take no specific action on the invoice. In this case, the seller
     * (or the application developer) follows up with the customer for payment. For example,
     * a seller might collect a payment in the Seller Dashboard or use the Point of Sale (POS) application.
     * The seller might also share the URL of the Square-hosted invoice page (`public_url`) with the
     * customer requesting payment.
     */
    public const SHARE_MANUALLY = 'SHARE_MANUALLY';

    /**
     * Directs Square to charge the bank account on file on the `due_date` specified in the
     * payment request and to use email to send invoices, reminders, and receipts.
     *
     * The bank on file payment method applies only to recurring invoices that sellers create in the Seller
     * Dashboard or other
     * Square first-party applications. The bank account is provided by the customer during the payment
     * flow. You
     * cannot set `CHARGE_BANK_ON_FILE` as a request method using the Invoices API.
     */
    public const CHARGE_BANK_ON_FILE = 'CHARGE_BANK_ON_FILE';

    /**
     * Directs Square to send invoices and receipts to the customer using SMS (text message). Square sends
     * the invoice
     * after it is published (either immediately or at the `scheduled_at` time, if specified in the
     * [invoice](entity:Invoice)).
     *
     * You cannot set `SMS` as a request method using the Invoices API.
     */
    public const SMS = 'SMS';

    /**
     * Directs Square to charge the card on file on the `due_date` specified in the payment request and to
     * use SMS (text message) to send invoices and receipts.
     *
     * You cannot set `SMS_CHARGE_CARD_ON_FILE` as a request method using the Invoices API.
     */
    public const SMS_CHARGE_CARD_ON_FILE = 'SMS_CHARGE_CARD_ON_FILE';

    /**
     * Directs Square to charge the bank account on file on the `due_date` specified in the payment
     * request
     * and to use SMS (text message) to send invoices and receipts.
     *
     * The bank on file payment method applies only to recurring invoices that sellers create in the Seller
     * Dashboard
     * or other Square first-party applications. The bank account is provided by the customer during the
     * payment flow.
     * You cannot set `SMS_CHARGE_BANK_ON_FILE` as a request method using the Invoices API.
     */
    public const SMS_CHARGE_BANK_ON_FILE = 'SMS_CHARGE_BANK_ON_FILE';
}
