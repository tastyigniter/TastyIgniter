<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\Money;
use Square\Models\PaymentBalanceActivityAppFeeRefundDetail;
use Square\Models\PaymentBalanceActivityAppFeeRevenueDetail;
use Square\Models\PaymentBalanceActivityAutomaticSavingsDetail;
use Square\Models\PaymentBalanceActivityAutomaticSavingsReversedDetail;
use Square\Models\PaymentBalanceActivityChargeDetail;
use Square\Models\PaymentBalanceActivityDepositFeeDetail;
use Square\Models\PaymentBalanceActivityDisputeDetail;
use Square\Models\PaymentBalanceActivityFeeDetail;
use Square\Models\PaymentBalanceActivityFreeProcessingDetail;
use Square\Models\PaymentBalanceActivityHoldAdjustmentDetail;
use Square\Models\PaymentBalanceActivityOpenDisputeDetail;
use Square\Models\PaymentBalanceActivityOtherAdjustmentDetail;
use Square\Models\PaymentBalanceActivityOtherDetail;
use Square\Models\PaymentBalanceActivityRefundDetail;
use Square\Models\PaymentBalanceActivityReleaseAdjustmentDetail;
use Square\Models\PaymentBalanceActivityReserveHoldDetail;
use Square\Models\PaymentBalanceActivityReserveReleaseDetail;
use Square\Models\PaymentBalanceActivitySquareCapitalPaymentDetail;
use Square\Models\PaymentBalanceActivitySquareCapitalReversedPaymentDetail;
use Square\Models\PaymentBalanceActivityTaxOnFeeDetail;
use Square\Models\PaymentBalanceActivityThirdPartyFeeDetail;
use Square\Models\PaymentBalanceActivityThirdPartyFeeRefundDetail;
use Square\Models\PayoutEntry;

/**
 * Builder for model PayoutEntry
 *
 * @see PayoutEntry
 */
class PayoutEntryBuilder
{
    /**
     * @var PayoutEntry
     */
    private $instance;

    private function __construct(PayoutEntry $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new payout entry Builder object.
     */
    public static function init(string $id, string $payoutId): self
    {
        return new self(new PayoutEntry($id, $payoutId));
    }

    /**
     * Sets effective at field.
     */
    public function effectiveAt(?string $value): self
    {
        $this->instance->setEffectiveAt($value);
        return $this;
    }

    /**
     * Unsets effective at field.
     */
    public function unsetEffectiveAt(): self
    {
        $this->instance->unsetEffectiveAt();
        return $this;
    }

    /**
     * Sets type field.
     */
    public function type(?string $value): self
    {
        $this->instance->setType($value);
        return $this;
    }

    /**
     * Sets gross amount money field.
     */
    public function grossAmountMoney(?Money $value): self
    {
        $this->instance->setGrossAmountMoney($value);
        return $this;
    }

    /**
     * Sets fee amount money field.
     */
    public function feeAmountMoney(?Money $value): self
    {
        $this->instance->setFeeAmountMoney($value);
        return $this;
    }

    /**
     * Sets net amount money field.
     */
    public function netAmountMoney(?Money $value): self
    {
        $this->instance->setNetAmountMoney($value);
        return $this;
    }

    /**
     * Sets type app fee revenue details field.
     */
    public function typeAppFeeRevenueDetails(?PaymentBalanceActivityAppFeeRevenueDetail $value): self
    {
        $this->instance->setTypeAppFeeRevenueDetails($value);
        return $this;
    }

    /**
     * Sets type app fee refund details field.
     */
    public function typeAppFeeRefundDetails(?PaymentBalanceActivityAppFeeRefundDetail $value): self
    {
        $this->instance->setTypeAppFeeRefundDetails($value);
        return $this;
    }

    /**
     * Sets type automatic savings details field.
     */
    public function typeAutomaticSavingsDetails(?PaymentBalanceActivityAutomaticSavingsDetail $value): self
    {
        $this->instance->setTypeAutomaticSavingsDetails($value);
        return $this;
    }

    /**
     * Sets type automatic savings reversed details field.
     */
    public function typeAutomaticSavingsReversedDetails(
        ?PaymentBalanceActivityAutomaticSavingsReversedDetail $value
    ): self {
        $this->instance->setTypeAutomaticSavingsReversedDetails($value);
        return $this;
    }

    /**
     * Sets type charge details field.
     */
    public function typeChargeDetails(?PaymentBalanceActivityChargeDetail $value): self
    {
        $this->instance->setTypeChargeDetails($value);
        return $this;
    }

    /**
     * Sets type deposit fee details field.
     */
    public function typeDepositFeeDetails(?PaymentBalanceActivityDepositFeeDetail $value): self
    {
        $this->instance->setTypeDepositFeeDetails($value);
        return $this;
    }

    /**
     * Sets type dispute details field.
     */
    public function typeDisputeDetails(?PaymentBalanceActivityDisputeDetail $value): self
    {
        $this->instance->setTypeDisputeDetails($value);
        return $this;
    }

    /**
     * Sets type fee details field.
     */
    public function typeFeeDetails(?PaymentBalanceActivityFeeDetail $value): self
    {
        $this->instance->setTypeFeeDetails($value);
        return $this;
    }

    /**
     * Sets type free processing details field.
     */
    public function typeFreeProcessingDetails(?PaymentBalanceActivityFreeProcessingDetail $value): self
    {
        $this->instance->setTypeFreeProcessingDetails($value);
        return $this;
    }

    /**
     * Sets type hold adjustment details field.
     */
    public function typeHoldAdjustmentDetails(?PaymentBalanceActivityHoldAdjustmentDetail $value): self
    {
        $this->instance->setTypeHoldAdjustmentDetails($value);
        return $this;
    }

    /**
     * Sets type open dispute details field.
     */
    public function typeOpenDisputeDetails(?PaymentBalanceActivityOpenDisputeDetail $value): self
    {
        $this->instance->setTypeOpenDisputeDetails($value);
        return $this;
    }

    /**
     * Sets type other details field.
     */
    public function typeOtherDetails(?PaymentBalanceActivityOtherDetail $value): self
    {
        $this->instance->setTypeOtherDetails($value);
        return $this;
    }

    /**
     * Sets type other adjustment details field.
     */
    public function typeOtherAdjustmentDetails(?PaymentBalanceActivityOtherAdjustmentDetail $value): self
    {
        $this->instance->setTypeOtherAdjustmentDetails($value);
        return $this;
    }

    /**
     * Sets type refund details field.
     */
    public function typeRefundDetails(?PaymentBalanceActivityRefundDetail $value): self
    {
        $this->instance->setTypeRefundDetails($value);
        return $this;
    }

    /**
     * Sets type release adjustment details field.
     */
    public function typeReleaseAdjustmentDetails(?PaymentBalanceActivityReleaseAdjustmentDetail $value): self
    {
        $this->instance->setTypeReleaseAdjustmentDetails($value);
        return $this;
    }

    /**
     * Sets type reserve hold details field.
     */
    public function typeReserveHoldDetails(?PaymentBalanceActivityReserveHoldDetail $value): self
    {
        $this->instance->setTypeReserveHoldDetails($value);
        return $this;
    }

    /**
     * Sets type reserve release details field.
     */
    public function typeReserveReleaseDetails(?PaymentBalanceActivityReserveReleaseDetail $value): self
    {
        $this->instance->setTypeReserveReleaseDetails($value);
        return $this;
    }

    /**
     * Sets type square capital payment details field.
     */
    public function typeSquareCapitalPaymentDetails(?PaymentBalanceActivitySquareCapitalPaymentDetail $value): self
    {
        $this->instance->setTypeSquareCapitalPaymentDetails($value);
        return $this;
    }

    /**
     * Sets type square capital reversed payment details field.
     */
    public function typeSquareCapitalReversedPaymentDetails(
        ?PaymentBalanceActivitySquareCapitalReversedPaymentDetail $value
    ): self {
        $this->instance->setTypeSquareCapitalReversedPaymentDetails($value);
        return $this;
    }

    /**
     * Sets type tax on fee details field.
     */
    public function typeTaxOnFeeDetails(?PaymentBalanceActivityTaxOnFeeDetail $value): self
    {
        $this->instance->setTypeTaxOnFeeDetails($value);
        return $this;
    }

    /**
     * Sets type third party fee details field.
     */
    public function typeThirdPartyFeeDetails(?PaymentBalanceActivityThirdPartyFeeDetail $value): self
    {
        $this->instance->setTypeThirdPartyFeeDetails($value);
        return $this;
    }

    /**
     * Sets type third party fee refund details field.
     */
    public function typeThirdPartyFeeRefundDetails(?PaymentBalanceActivityThirdPartyFeeRefundDetail $value): self
    {
        $this->instance->setTypeThirdPartyFeeRefundDetails($value);
        return $this;
    }

    /**
     * Initializes a new payout entry object.
     */
    public function build(): PayoutEntry
    {
        return CoreHelper::clone($this->instance);
    }
}
