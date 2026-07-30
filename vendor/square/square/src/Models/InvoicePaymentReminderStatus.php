<?php

declare(strict_types=1);

namespace Square\Models;

/**
 * The status of a payment request reminder.
 */
class InvoicePaymentReminderStatus
{
    /**
     * The reminder will be sent on the `relative_scheduled_date` (if the invoice is published).
     */
    public const PENDING = 'PENDING';

    /**
     * The reminder is not applicable and is not sent. The following are examples
     * of when reminders are not applicable and are not sent:
     * - You schedule a reminder to be sent before the invoice is published.
     * - The invoice is configured with multiple payment requests and a payment request reminder
     * is configured to be sent after the next payment request `due_date`.
     * - Two reminders (for different payment requests) are configured to be sent on the
     * same date. Therefore, only one reminder is sent.
     * - You configure a reminder to be sent on the date that the invoice is scheduled to be sent.
     * - The payment request is already paid.
     * - The invoice status is `CANCELED` or `FAILED`.
     */
    public const NOT_APPLICABLE = 'NOT_APPLICABLE';

    /**
     * The reminder is sent.
     */
    public const SENT = 'SENT';
}
