<?php

declare(strict_types=1);

namespace Square\Models;

/**
 * The type of the dispute evidence.
 */
class DisputeEvidenceType
{
    /**
     * Square assumes this evidence type if you do not provide a type when uploading evidence.
     *
     * Use when uploading evidence as a file or string.
     */
    public const GENERIC_EVIDENCE = 'GENERIC_EVIDENCE';

    /**
     * Server or activity logs that show proof of the cardholder’s identity and that the
     * cardholder successfully ordered and received the goods (digitally or otherwise).
     * Example evidence includes IP addresses, corresponding timestamps/dates, cardholder’s name and email
     * address linked to a cardholder profile held by the seller, proof the same device and card (used
     * in dispute) were previously used in prior undisputed transaction, and any related detailed activity.
     *
     * Use when uploading evidence as a file or string.
     */
    public const ONLINE_OR_APP_ACCESS_LOG = 'ONLINE_OR_APP_ACCESS_LOG';

    /**
     * Evidence that the cardholder did provide authorization for the charge.
     * Example evidence includes a signed credit card authorization.
     *
     * Use when uploading evidence as a file.
     */
    public const AUTHORIZATION_DOCUMENTATION = 'AUTHORIZATION_DOCUMENTATION';

    /**
     * Evidence that the cardholder acknowledged your refund or cancellation policy.
     * Example evidence includes a signature or checkbox showing the cardholder’s acknowledgement of your
     * refund or cancellation policy.
     *
     * Use when uploading evidence as a file or string.
     */
    public const CANCELLATION_OR_REFUND_DOCUMENTATION = 'CANCELLATION_OR_REFUND_DOCUMENTATION';

    /**
     * Evidence that shows relevant communication with the cardholder.
     * Example evidence includes emails or texts that show the cardholder received goods/services or
     * demonstrate cardholder satisfaction.
     *
     * Use when uploading evidence as a file.
     */
    public const CARDHOLDER_COMMUNICATION = 'CARDHOLDER_COMMUNICATION';

    /**
     * Evidence that validates the customer's identity.
     * Example evidence includes personally identifiable details such as name, email address, purchaser IP
     * address, and a copy of the cardholder ID.
     *
     * Use when uploading evidence as a file or string.
     */
    public const CARDHOLDER_INFORMATION = 'CARDHOLDER_INFORMATION';

    /**
     * Evidence that shows proof of the sale/transaction.
     * Example evidence includes an invoice, contract, or other item showing the customer’s
     * acknowledgement
     * of the purchase and your terms.
     *
     * Use when uploading evidence as a file or string.
     */
    public const PURCHASE_ACKNOWLEDGEMENT = 'PURCHASE_ACKNOWLEDGEMENT';

    /**
     * Evidence that shows the charges in question are valid and distinct from one another.
     * Example evidence includes receipts, shipping labels, and invoices along with their distinct payment
     * IDs.
     *
     * Use when uploading evidence as a file.
     */
    public const DUPLICATE_CHARGE_DOCUMENTATION = 'DUPLICATE_CHARGE_DOCUMENTATION';

    /**
     * A description of the product or service sold.
     *
     * Use when uploading evidence as a file or string.
     */
    public const PRODUCT_OR_SERVICE_DESCRIPTION = 'PRODUCT_OR_SERVICE_DESCRIPTION';

    /**
     * A receipt or message sent to the cardholder detailing the charge.
     * Note: You do not need to upload the Square receipt; Square submits the receipt on your behalf.
     *
     * Use when uploading evidence as a file or string.
     */
    public const RECEIPT = 'RECEIPT';

    /**
     * Evidence that the service was provided to the cardholder or the expected date that services will be
     * rendered.
     * Example evidence includes a signed delivery form, work order, expected delivery date, or other
     * written agreements.
     *
     * Use when uploading evidence as a file or string.
     */
    public const SERVICE_RECEIVED_DOCUMENTATION = 'SERVICE_RECEIVED_DOCUMENTATION';

    /**
     * Evidence that shows the product was provided to the cardholder or the expected date of delivery.
     * Example evidence includes a signed delivery form or written agreement acknowledging receipt of the
     * goods or services.
     *
     * Use when uploading evidence as a file or string.
     */
    public const PROOF_OF_DELIVERY_DOCUMENTATION = 'PROOF_OF_DELIVERY_DOCUMENTATION';

    /**
     * Evidence that shows the cardholder previously processed transactions on the same card and did not
     * dispute them.
     * Note: Square automatically provides up to five distinct Square receipts for related transactions,
     * when available.
     *
     * Use when uploading evidence as a file or string.
     */
    public const RELATED_TRANSACTION_DOCUMENTATION = 'RELATED_TRANSACTION_DOCUMENTATION';

    /**
     * An explanation of why the cardholder’s claim is invalid.
     * Example evidence includes an explanation of why each distinct charge is a legitimate purchase, why
     * the cardholder’s claim
     * for credit owed due to their attempt to cancel, return, or refund is invalid per your stated policy
     * and cardholder
     * agreement, or an explanation of how the cardholder did not attempt to remedy the issue with you
     * first to receive credit.
     *
     * Use when uploading evidence as a file or string.
     */
    public const REBUTTAL_EXPLANATION = 'REBUTTAL_EXPLANATION';

    /**
     * The tracking number for the order provided by the shipping carrier. If you have multiple numbers,
     * they need to be
     * submitted individually as separate pieces of evidence.
     *
     * Use when uploading evidence as a string.
     */
    public const TRACKING_NUMBER = 'TRACKING_NUMBER';
}
