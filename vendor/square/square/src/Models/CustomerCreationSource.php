<?php

declare(strict_types=1);

namespace Square\Models;

/**
 * Indicates the method used to create the customer profile.
 */
class CustomerCreationSource
{
    /**
     * The default creation source. This source is typically used for backward/future
     * compatibility when the original source of a customer profile is
     * unrecognized. For example, when older clients do not support newer
     * source types.
     */
    public const OTHER = 'OTHER';

    /**
     * The customer profile was created automatically when an appointment
     * was scheduled.
     */
    public const APPOINTMENTS = 'APPOINTMENTS';

    /**
     * The customer profile was created automatically when a coupon was issued
     * using Square Point of Sale.
     */
    public const COUPON = 'COUPON';

    /**
     * The customer profile was restored through Square's deletion recovery
     * process.
     */
    public const DELETION_RECOVERY = 'DELETION_RECOVERY';

    /**
     * The customer profile was created manually through Square Seller Dashboard or the
     * Point of Sale application.
     */
    public const DIRECTORY = 'DIRECTORY';

    /**
     * The customer profile was created automatically when a gift card was
     * issued using Square Point of Sale. Customer profiles are created for
     * both the buyer and the recipient of the gift card.
     */
    public const EGIFTING = 'EGIFTING';

    /**
     * The customer profile was created through Square Point of Sale when
     * signing up for marketing emails during checkout.
     */
    public const EMAIL_COLLECTION = 'EMAIL_COLLECTION';

    /**
     * The customer profile was created automatically when providing feedback
     * through a digital receipt.
     */
    public const FEEDBACK = 'FEEDBACK';

    /**
     * The customer profile was created automatically when importing customer
     * data through Square Seller Dashboard.
     */
    public const IMPORT = 'IMPORT';

    /**
     * The customer profile was created automatically during an invoice payment.
     */
    public const INVOICES = 'INVOICES';

    /**
     * The customer profile was created automatically when customers provide a
     * phone number for loyalty reward programs during checkout.
     */
    public const LOYALTY = 'LOYALTY';

    /**
     * The customer profile was created as the result of a campaign managed
     * through Square’s Facebook integration.
     */
    public const MARKETING = 'MARKETING';

    /**
     * The customer profile was created as the result of explicitly merging
     * multiple customer profiles through the Square Seller Dashboard or the Point of
     * Sale application.
     */
    public const MERGE = 'MERGE';

    /**
     * The customer profile was created through Square's Online Store solution
     * (legacy service).
     */
    public const ONLINE_STORE = 'ONLINE_STORE';

    /**
     * The customer profile was created automatically as the result of a successful
     * transaction that did not explicitly link to an existing customer profile.
     */
    public const INSTANT_PROFILE = 'INSTANT_PROFILE';

    /**
     * The customer profile was created through Square's Virtual Terminal.
     */
    public const TERMINAL = 'TERMINAL';

    /**
     * The customer profile was created through a Square API call.
     */
    public const THIRD_PARTY = 'THIRD_PARTY';

    /**
     * The customer profile was created by a third-party product and imported
     * through an official integration.
     */
    public const THIRD_PARTY_IMPORT = 'THIRD_PARTY_IMPORT';

    /**
     * The customer profile was restored through Square's unmerge recovery
     * process.
     */
    public const UNMERGE_RECOVERY = 'UNMERGE_RECOVERY';
}
