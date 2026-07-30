<?php

declare(strict_types=1);

namespace Square\Models;

/**
 * Indicates the type of [gift card activity]($m/GiftCardActivity).
 */
class GiftCardActivityType
{
    /**
     * Activated a gift card with a balance. When a gift card is activated, Square changes
     * the gift card state from `PENDING` to `ACTIVE`. A gift card must be in the `ACTIVE` state
     * to be used for other balance-changing activities.
     */
    public const ACTIVATE = 'ACTIVATE';

    /**
     * Loaded a gift card with additional funds.
     */
    public const LOAD = 'LOAD';

    /**
     * Redeemed a gift card for a purchase.
     */
    public const REDEEM = 'REDEEM';

    /**
     * Set the balance of a gift card to zero.
     */
    public const CLEAR_BALANCE = 'CLEAR_BALANCE';

    /**
     * Permanently blocked a gift card from balance-changing activities.
     */
    public const DEACTIVATE = 'DEACTIVATE';

    /**
     * Added money to a gift card outside of a typical `ACTIVATE`, `LOAD`, or `REFUND` activity flow.
     */
    public const ADJUST_INCREMENT = 'ADJUST_INCREMENT';

    /**
     * Deducted money from a gift card outside of a typical `REDEEM` activity flow.
     */
    public const ADJUST_DECREMENT = 'ADJUST_DECREMENT';

    /**
     * Added money to a gift card from a refunded transaction. A `REFUND` activity might be linked to
     * a Square payment, depending on how the payment and refund are processed. For example:
     * - A gift card payment processed by Square can be refunded to the same gift card using Square Point
     * of Sale,
     * the Square Seller Dashboard, or the Refunds API.
     * - A cross-tender payment processed by Square can be refunded to a gift card using Square Point of
     * Sale or the
     * Square Seller Dashboard. The payment source might be a credit card or different gift card.
     * - A payment processed using a custom payment processing system can be refunded to the same gift card.
     */
    public const REFUND = 'REFUND';

    /**
     * Added money to a gift card from a refunded transaction that was processed using a custom payment
     * processing system and not linked to the gift card.
     */
    public const UNLINKED_ACTIVITY_REFUND = 'UNLINKED_ACTIVITY_REFUND';

    /**
     * Imported a third-party gift card with a balance. `IMPORT` activities are managed
     * by Square and cannot be created using the Gift Card Activities API.
     */
    public const IMPORT = 'IMPORT';

    /**
     * Temporarily blocked a gift card from balance-changing activities. `BLOCK` activities
     * are managed by Square and cannot be created using the Gift Card Activities API.
     */
    public const BLOCK = 'BLOCK';

    /**
     * Unblocked a gift card, which enables it to resume balance-changing activities. `UNBLOCK`
     * activities are managed by Square and cannot be created using the Gift Card Activities API.
     */
    public const UNBLOCK = 'UNBLOCK';

    /**
     * Reversed the import of a third-party gift card, which sets the gift card state to
     * `PENDING` and clears the balance. `IMPORT_REVERSAL` activities are managed by Square and
     * cannot be created using the Gift Card Activities API.
     */
    public const IMPORT_REVERSAL = 'IMPORT_REVERSAL';

    /**
     * Deducted money from a gift card as the result of a transfer to the balance of another gift card.
     * `TRANSFER_BALANCE_FROM` activities are managed by Square and cannot be created using the Gift Card
     * Activities API.
     */
    public const TRANSFER_BALANCE_FROM = 'TRANSFER_BALANCE_FROM';

    /**
     * Added money to a gift card as the result of a transfer from the balance of another gift card.
     * `TRANSFER_BALANCE_TO` activities are managed by Square and cannot be created using the Gift Card
     * Activities API.
     */
    public const TRANSFER_BALANCE_TO = 'TRANSFER_BALANCE_TO';
}
