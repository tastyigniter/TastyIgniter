<?php

declare(strict_types=1);

namespace Square\Models;

class ActivityType
{
    /**
     * A manual adjustment applied to the seller's account by Square.
     */
    public const ADJUSTMENT = 'ADJUSTMENT';

    /**
     * A refund for an application fee on a payment.
     */
    public const APP_FEE_REFUND = 'APP_FEE_REFUND';

    /**
     * Revenue generated from an application fee on a payment.
     */
    public const APP_FEE_REVENUE = 'APP_FEE_REVENUE';

    /**
     * An automatic transfer from the payment processing balance to the Square Savings account.
     * These are, generally, proportional to the seller's sales.
     */
    public const AUTOMATIC_SAVINGS = 'AUTOMATIC_SAVINGS';

    /**
     * An automatic transfer from the Square Savings account back to the processing balance.
     * These are, generally, proportional to the seller's refunds.
     */
    public const AUTOMATIC_SAVINGS_REVERSED = 'AUTOMATIC_SAVINGS_REVERSED';

    /**
     * A credit card payment capture.
     */
    public const CHARGE = 'CHARGE';

    /**
     * Any fees involved with deposits such as instant deposits.
     */
    public const DEPOSIT_FEE = 'DEPOSIT_FEE';

    /**
     * The balance change due to a dispute event.
     */
    public const DISPUTE = 'DISPUTE';

    /**
     * An escheatment entry for remittance.
     */
    public const ESCHEATMENT = 'ESCHEATMENT';

    /**
     * The Square processing fee.
     */
    public const FEE = 'FEE';

    /**
     * Square offers free payments processing for a variety of business scenarios, including seller
     * referrals or when Square wants to apologize (for example, for a bug, customer service, or repricing
     * complication).
     * This entry represents a credit to the seller for the purposes of free processing.
     */
    public const FREE_PROCESSING = 'FREE_PROCESSING';

    /**
     * An adjustment made by Square related to holding a payment.
     */
    public const HOLD_ADJUSTMENT = 'HOLD_ADJUSTMENT';

    /**
     * An external change to a seller's balance. Initial, in the sense that it
     * causes the creation of the other activity types, such as hold and refund.
     */
    public const INITIAL_BALANCE_CHANGE = 'INITIAL_BALANCE_CHANGE';

    /**
     * The balance change from a money transfer.
     */
    public const MONEY_TRANSFER = 'MONEY_TRANSFER';

    /**
     * The reversal of a money transfer.
     */
    public const MONEY_TRANSFER_REVERSAL = 'MONEY_TRANSFER_REVERSAL';

    /**
     * The balance change for a chargeback that has been filed.
     */
    public const OPEN_DISPUTE = 'OPEN_DISPUTE';

    /**
     * Any other type that does not belong in the rest of the types.
     */
    public const OTHER = 'OTHER';

    /**
     * Any other type of adjustment that does not fall under existing types.
     */
    public const OTHER_ADJUSTMENT = 'OTHER_ADJUSTMENT';

    /**
     * A fee paid to a third-party merchant.
     */
    public const PAID_SERVICE_FEE = 'PAID_SERVICE_FEE';

    /**
     * A fee paid to a third-party merchant.
     */
    public const PAID_SERVICE_FEE_REFUND = 'PAID_SERVICE_FEE_REFUND';

    /**
     * Repayment for a redemption code.
     */
    public const REDEMPTION_CODE = 'REDEMPTION_CODE';

    /**
     * A refund for an existing card payment.
     */
    public const REFUND = 'REFUND';

    /**
     * An adjustment made by Square related to releasing a payment.
     */
    public const RELEASE_ADJUSTMENT = 'RELEASE_ADJUSTMENT';

    /**
     * Fees paid for funding risk reserve.
     */
    public const RESERVE_HOLD = 'RESERVE_HOLD';

    /**
     * Fees released from risk reserve.
     */
    public const RESERVE_RELEASE = 'RESERVE_RELEASE';

    /**
     * An entry created when Square receives a response for the ACH file that Square sent indicating that
     * the
     * settlement of the original entry failed.
     */
    public const RETURNED_PAYOUT = 'RETURNED_PAYOUT';

    /**
     * A capital merchant cash advance (MCA) assessment. These are, generally,
     * proportional to the merchant's sales but can be issued for other reasons related to the MCA.
     */
    public const SQUARE_CAPITAL_PAYMENT = 'SQUARE_CAPITAL_PAYMENT';

    /**
     * A capital merchant cash advance (MCA) assessment refund. These are, generally,
     * proportional to the merchant's refunds but can be issued for other reasons related to the MCA.
     */
    public const SQUARE_CAPITAL_REVERSED_PAYMENT = 'SQUARE_CAPITAL_REVERSED_PAYMENT';

    /**
     * A fee charged for subscription to a Square product.
     */
    public const SUBSCRIPTION_FEE = 'SUBSCRIPTION_FEE';

    /**
     * A Square subscription fee that has been refunded.
     */
    public const SUBSCRIPTION_FEE_PAID_REFUND = 'SUBSCRIPTION_FEE_PAID_REFUND';

    /**
     * The refund of a previously charged Square product subscription fee.
     */
    public const SUBSCRIPTION_FEE_REFUND = 'SUBSCRIPTION_FEE_REFUND';

    /**
     * The tax paid on fee amounts.
     */
    public const TAX_ON_FEE = 'TAX_ON_FEE';

    /**
     * Fees collected by a third-party platform.
     */
    public const THIRD_PARTY_FEE = 'THIRD_PARTY_FEE';

    /**
     * Refunded fees from a third-party platform.
     */
    public const THIRD_PARTY_FEE_REFUND = 'THIRD_PARTY_FEE_REFUND';

    /**
     * Balance change due to money transfer.
     */
    public const PAYOUT = 'PAYOUT';
}
