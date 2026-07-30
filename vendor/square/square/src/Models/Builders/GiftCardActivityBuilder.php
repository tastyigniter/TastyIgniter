<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\GiftCardActivity;
use Square\Models\GiftCardActivityActivate;
use Square\Models\GiftCardActivityAdjustDecrement;
use Square\Models\GiftCardActivityAdjustIncrement;
use Square\Models\GiftCardActivityBlock;
use Square\Models\GiftCardActivityClearBalance;
use Square\Models\GiftCardActivityDeactivate;
use Square\Models\GiftCardActivityImport;
use Square\Models\GiftCardActivityImportReversal;
use Square\Models\GiftCardActivityLoad;
use Square\Models\GiftCardActivityRedeem;
use Square\Models\GiftCardActivityRefund;
use Square\Models\GiftCardActivityTransferBalanceFrom;
use Square\Models\GiftCardActivityTransferBalanceTo;
use Square\Models\GiftCardActivityUnblock;
use Square\Models\GiftCardActivityUnlinkedActivityRefund;
use Square\Models\Money;

/**
 * Builder for model GiftCardActivity
 *
 * @see GiftCardActivity
 */
class GiftCardActivityBuilder
{
    /**
     * @var GiftCardActivity
     */
    private $instance;

    private function __construct(GiftCardActivity $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new gift card activity Builder object.
     */
    public static function init(string $type, string $locationId): self
    {
        return new self(new GiftCardActivity($type, $locationId));
    }

    /**
     * Sets id field.
     */
    public function id(?string $value): self
    {
        $this->instance->setId($value);
        return $this;
    }

    /**
     * Sets created at field.
     */
    public function createdAt(?string $value): self
    {
        $this->instance->setCreatedAt($value);
        return $this;
    }

    /**
     * Sets gift card id field.
     */
    public function giftCardId(?string $value): self
    {
        $this->instance->setGiftCardId($value);
        return $this;
    }

    /**
     * Unsets gift card id field.
     */
    public function unsetGiftCardId(): self
    {
        $this->instance->unsetGiftCardId();
        return $this;
    }

    /**
     * Sets gift card gan field.
     */
    public function giftCardGan(?string $value): self
    {
        $this->instance->setGiftCardGan($value);
        return $this;
    }

    /**
     * Unsets gift card gan field.
     */
    public function unsetGiftCardGan(): self
    {
        $this->instance->unsetGiftCardGan();
        return $this;
    }

    /**
     * Sets gift card balance money field.
     */
    public function giftCardBalanceMoney(?Money $value): self
    {
        $this->instance->setGiftCardBalanceMoney($value);
        return $this;
    }

    /**
     * Sets load activity details field.
     */
    public function loadActivityDetails(?GiftCardActivityLoad $value): self
    {
        $this->instance->setLoadActivityDetails($value);
        return $this;
    }

    /**
     * Sets activate activity details field.
     */
    public function activateActivityDetails(?GiftCardActivityActivate $value): self
    {
        $this->instance->setActivateActivityDetails($value);
        return $this;
    }

    /**
     * Sets redeem activity details field.
     */
    public function redeemActivityDetails(?GiftCardActivityRedeem $value): self
    {
        $this->instance->setRedeemActivityDetails($value);
        return $this;
    }

    /**
     * Sets clear balance activity details field.
     */
    public function clearBalanceActivityDetails(?GiftCardActivityClearBalance $value): self
    {
        $this->instance->setClearBalanceActivityDetails($value);
        return $this;
    }

    /**
     * Sets deactivate activity details field.
     */
    public function deactivateActivityDetails(?GiftCardActivityDeactivate $value): self
    {
        $this->instance->setDeactivateActivityDetails($value);
        return $this;
    }

    /**
     * Sets adjust increment activity details field.
     */
    public function adjustIncrementActivityDetails(?GiftCardActivityAdjustIncrement $value): self
    {
        $this->instance->setAdjustIncrementActivityDetails($value);
        return $this;
    }

    /**
     * Sets adjust decrement activity details field.
     */
    public function adjustDecrementActivityDetails(?GiftCardActivityAdjustDecrement $value): self
    {
        $this->instance->setAdjustDecrementActivityDetails($value);
        return $this;
    }

    /**
     * Sets refund activity details field.
     */
    public function refundActivityDetails(?GiftCardActivityRefund $value): self
    {
        $this->instance->setRefundActivityDetails($value);
        return $this;
    }

    /**
     * Sets unlinked activity refund activity details field.
     */
    public function unlinkedActivityRefundActivityDetails(?GiftCardActivityUnlinkedActivityRefund $value): self
    {
        $this->instance->setUnlinkedActivityRefundActivityDetails($value);
        return $this;
    }

    /**
     * Sets import activity details field.
     */
    public function importActivityDetails(?GiftCardActivityImport $value): self
    {
        $this->instance->setImportActivityDetails($value);
        return $this;
    }

    /**
     * Sets block activity details field.
     */
    public function blockActivityDetails(?GiftCardActivityBlock $value): self
    {
        $this->instance->setBlockActivityDetails($value);
        return $this;
    }

    /**
     * Sets unblock activity details field.
     */
    public function unblockActivityDetails(?GiftCardActivityUnblock $value): self
    {
        $this->instance->setUnblockActivityDetails($value);
        return $this;
    }

    /**
     * Sets import reversal activity details field.
     */
    public function importReversalActivityDetails(?GiftCardActivityImportReversal $value): self
    {
        $this->instance->setImportReversalActivityDetails($value);
        return $this;
    }

    /**
     * Sets transfer balance to activity details field.
     */
    public function transferBalanceToActivityDetails(?GiftCardActivityTransferBalanceTo $value): self
    {
        $this->instance->setTransferBalanceToActivityDetails($value);
        return $this;
    }

    /**
     * Sets transfer balance from activity details field.
     */
    public function transferBalanceFromActivityDetails(?GiftCardActivityTransferBalanceFrom $value): self
    {
        $this->instance->setTransferBalanceFromActivityDetails($value);
        return $this;
    }

    /**
     * Initializes a new gift card activity object.
     */
    public function build(): GiftCardActivity
    {
        return CoreHelper::clone($this->instance);
    }
}
