<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * One or more PayoutEntries that make up a Payout. Each one has a date, amount, and type of activity.
 * The total amount of the payout will equal the sum of the payout entries for a batch payout
 */
class PayoutEntry implements \JsonSerializable
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $payoutId;

    /**
     * @var array
     */
    private $effectiveAt = [];

    /**
     * @var string|null
     */
    private $type;

    /**
     * @var Money|null
     */
    private $grossAmountMoney;

    /**
     * @var Money|null
     */
    private $feeAmountMoney;

    /**
     * @var Money|null
     */
    private $netAmountMoney;

    /**
     * @var PaymentBalanceActivityAppFeeRevenueDetail|null
     */
    private $typeAppFeeRevenueDetails;

    /**
     * @var PaymentBalanceActivityAppFeeRefundDetail|null
     */
    private $typeAppFeeRefundDetails;

    /**
     * @var PaymentBalanceActivityAutomaticSavingsDetail|null
     */
    private $typeAutomaticSavingsDetails;

    /**
     * @var PaymentBalanceActivityAutomaticSavingsReversedDetail|null
     */
    private $typeAutomaticSavingsReversedDetails;

    /**
     * @var PaymentBalanceActivityChargeDetail|null
     */
    private $typeChargeDetails;

    /**
     * @var PaymentBalanceActivityDepositFeeDetail|null
     */
    private $typeDepositFeeDetails;

    /**
     * @var PaymentBalanceActivityDisputeDetail|null
     */
    private $typeDisputeDetails;

    /**
     * @var PaymentBalanceActivityFeeDetail|null
     */
    private $typeFeeDetails;

    /**
     * @var PaymentBalanceActivityFreeProcessingDetail|null
     */
    private $typeFreeProcessingDetails;

    /**
     * @var PaymentBalanceActivityHoldAdjustmentDetail|null
     */
    private $typeHoldAdjustmentDetails;

    /**
     * @var PaymentBalanceActivityOpenDisputeDetail|null
     */
    private $typeOpenDisputeDetails;

    /**
     * @var PaymentBalanceActivityOtherDetail|null
     */
    private $typeOtherDetails;

    /**
     * @var PaymentBalanceActivityOtherAdjustmentDetail|null
     */
    private $typeOtherAdjustmentDetails;

    /**
     * @var PaymentBalanceActivityRefundDetail|null
     */
    private $typeRefundDetails;

    /**
     * @var PaymentBalanceActivityReleaseAdjustmentDetail|null
     */
    private $typeReleaseAdjustmentDetails;

    /**
     * @var PaymentBalanceActivityReserveHoldDetail|null
     */
    private $typeReserveHoldDetails;

    /**
     * @var PaymentBalanceActivityReserveReleaseDetail|null
     */
    private $typeReserveReleaseDetails;

    /**
     * @var PaymentBalanceActivitySquareCapitalPaymentDetail|null
     */
    private $typeSquareCapitalPaymentDetails;

    /**
     * @var PaymentBalanceActivitySquareCapitalReversedPaymentDetail|null
     */
    private $typeSquareCapitalReversedPaymentDetails;

    /**
     * @var PaymentBalanceActivityTaxOnFeeDetail|null
     */
    private $typeTaxOnFeeDetails;

    /**
     * @var PaymentBalanceActivityThirdPartyFeeDetail|null
     */
    private $typeThirdPartyFeeDetails;

    /**
     * @var PaymentBalanceActivityThirdPartyFeeRefundDetail|null
     */
    private $typeThirdPartyFeeRefundDetails;

    /**
     * @param string $id
     * @param string $payoutId
     */
    public function __construct(string $id, string $payoutId)
    {
        $this->id = $id;
        $this->payoutId = $payoutId;
    }

    /**
     * Returns Id.
     * A unique ID for the payout entry.
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * Sets Id.
     * A unique ID for the payout entry.
     *
     * @required
     * @maps id
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * Returns Payout Id.
     * The ID of the payout entries’ associated payout.
     */
    public function getPayoutId(): string
    {
        return $this->payoutId;
    }

    /**
     * Sets Payout Id.
     * The ID of the payout entries’ associated payout.
     *
     * @required
     * @maps payout_id
     */
    public function setPayoutId(string $payoutId): void
    {
        $this->payoutId = $payoutId;
    }

    /**
     * Returns Effective At.
     * The timestamp of when the payout entry affected the balance, in RFC 3339 format.
     */
    public function getEffectiveAt(): ?string
    {
        if (count($this->effectiveAt) == 0) {
            return null;
        }
        return $this->effectiveAt['value'];
    }

    /**
     * Sets Effective At.
     * The timestamp of when the payout entry affected the balance, in RFC 3339 format.
     *
     * @maps effective_at
     */
    public function setEffectiveAt(?string $effectiveAt): void
    {
        $this->effectiveAt['value'] = $effectiveAt;
    }

    /**
     * Unsets Effective At.
     * The timestamp of when the payout entry affected the balance, in RFC 3339 format.
     */
    public function unsetEffectiveAt(): void
    {
        $this->effectiveAt = [];
    }

    /**
     * Returns Type.
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * Sets Type.
     *
     * @maps type
     */
    public function setType(?string $type): void
    {
        $this->type = $type;
    }

    /**
     * Returns Gross Amount Money.
     * Represents an amount of money. `Money` fields can be signed or unsigned.
     * Fields that do not explicitly define whether they are signed or unsigned are
     * considered unsigned and can only hold positive amounts. For signed fields, the
     * sign of the value indicates the purpose of the money transfer. See
     * [Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-
     * monetary-amounts)
     * for more information.
     */
    public function getGrossAmountMoney(): ?Money
    {
        return $this->grossAmountMoney;
    }

    /**
     * Sets Gross Amount Money.
     * Represents an amount of money. `Money` fields can be signed or unsigned.
     * Fields that do not explicitly define whether they are signed or unsigned are
     * considered unsigned and can only hold positive amounts. For signed fields, the
     * sign of the value indicates the purpose of the money transfer. See
     * [Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-
     * monetary-amounts)
     * for more information.
     *
     * @maps gross_amount_money
     */
    public function setGrossAmountMoney(?Money $grossAmountMoney): void
    {
        $this->grossAmountMoney = $grossAmountMoney;
    }

    /**
     * Returns Fee Amount Money.
     * Represents an amount of money. `Money` fields can be signed or unsigned.
     * Fields that do not explicitly define whether they are signed or unsigned are
     * considered unsigned and can only hold positive amounts. For signed fields, the
     * sign of the value indicates the purpose of the money transfer. See
     * [Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-
     * monetary-amounts)
     * for more information.
     */
    public function getFeeAmountMoney(): ?Money
    {
        return $this->feeAmountMoney;
    }

    /**
     * Sets Fee Amount Money.
     * Represents an amount of money. `Money` fields can be signed or unsigned.
     * Fields that do not explicitly define whether they are signed or unsigned are
     * considered unsigned and can only hold positive amounts. For signed fields, the
     * sign of the value indicates the purpose of the money transfer. See
     * [Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-
     * monetary-amounts)
     * for more information.
     *
     * @maps fee_amount_money
     */
    public function setFeeAmountMoney(?Money $feeAmountMoney): void
    {
        $this->feeAmountMoney = $feeAmountMoney;
    }

    /**
     * Returns Net Amount Money.
     * Represents an amount of money. `Money` fields can be signed or unsigned.
     * Fields that do not explicitly define whether they are signed or unsigned are
     * considered unsigned and can only hold positive amounts. For signed fields, the
     * sign of the value indicates the purpose of the money transfer. See
     * [Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-
     * monetary-amounts)
     * for more information.
     */
    public function getNetAmountMoney(): ?Money
    {
        return $this->netAmountMoney;
    }

    /**
     * Sets Net Amount Money.
     * Represents an amount of money. `Money` fields can be signed or unsigned.
     * Fields that do not explicitly define whether they are signed or unsigned are
     * considered unsigned and can only hold positive amounts. For signed fields, the
     * sign of the value indicates the purpose of the money transfer. See
     * [Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-
     * monetary-amounts)
     * for more information.
     *
     * @maps net_amount_money
     */
    public function setNetAmountMoney(?Money $netAmountMoney): void
    {
        $this->netAmountMoney = $netAmountMoney;
    }

    /**
     * Returns Type App Fee Revenue Details.
     */
    public function getTypeAppFeeRevenueDetails(): ?PaymentBalanceActivityAppFeeRevenueDetail
    {
        return $this->typeAppFeeRevenueDetails;
    }

    /**
     * Sets Type App Fee Revenue Details.
     *
     * @maps type_app_fee_revenue_details
     */
    public function setTypeAppFeeRevenueDetails(
        ?PaymentBalanceActivityAppFeeRevenueDetail $typeAppFeeRevenueDetails
    ): void {
        $this->typeAppFeeRevenueDetails = $typeAppFeeRevenueDetails;
    }

    /**
     * Returns Type App Fee Refund Details.
     */
    public function getTypeAppFeeRefundDetails(): ?PaymentBalanceActivityAppFeeRefundDetail
    {
        return $this->typeAppFeeRefundDetails;
    }

    /**
     * Sets Type App Fee Refund Details.
     *
     * @maps type_app_fee_refund_details
     */
    public function setTypeAppFeeRefundDetails(
        ?PaymentBalanceActivityAppFeeRefundDetail $typeAppFeeRefundDetails
    ): void {
        $this->typeAppFeeRefundDetails = $typeAppFeeRefundDetails;
    }

    /**
     * Returns Type Automatic Savings Details.
     */
    public function getTypeAutomaticSavingsDetails(): ?PaymentBalanceActivityAutomaticSavingsDetail
    {
        return $this->typeAutomaticSavingsDetails;
    }

    /**
     * Sets Type Automatic Savings Details.
     *
     * @maps type_automatic_savings_details
     */
    public function setTypeAutomaticSavingsDetails(
        ?PaymentBalanceActivityAutomaticSavingsDetail $typeAutomaticSavingsDetails
    ): void {
        $this->typeAutomaticSavingsDetails = $typeAutomaticSavingsDetails;
    }

    /**
     * Returns Type Automatic Savings Reversed Details.
     */
    public function getTypeAutomaticSavingsReversedDetails(): ?PaymentBalanceActivityAutomaticSavingsReversedDetail
    {
        return $this->typeAutomaticSavingsReversedDetails;
    }

    /**
     * Sets Type Automatic Savings Reversed Details.
     *
     * @maps type_automatic_savings_reversed_details
     */
    public function setTypeAutomaticSavingsReversedDetails(
        ?PaymentBalanceActivityAutomaticSavingsReversedDetail $typeAutomaticSavingsReversedDetails
    ): void {
        $this->typeAutomaticSavingsReversedDetails = $typeAutomaticSavingsReversedDetails;
    }

    /**
     * Returns Type Charge Details.
     */
    public function getTypeChargeDetails(): ?PaymentBalanceActivityChargeDetail
    {
        return $this->typeChargeDetails;
    }

    /**
     * Sets Type Charge Details.
     *
     * @maps type_charge_details
     */
    public function setTypeChargeDetails(?PaymentBalanceActivityChargeDetail $typeChargeDetails): void
    {
        $this->typeChargeDetails = $typeChargeDetails;
    }

    /**
     * Returns Type Deposit Fee Details.
     */
    public function getTypeDepositFeeDetails(): ?PaymentBalanceActivityDepositFeeDetail
    {
        return $this->typeDepositFeeDetails;
    }

    /**
     * Sets Type Deposit Fee Details.
     *
     * @maps type_deposit_fee_details
     */
    public function setTypeDepositFeeDetails(?PaymentBalanceActivityDepositFeeDetail $typeDepositFeeDetails): void
    {
        $this->typeDepositFeeDetails = $typeDepositFeeDetails;
    }

    /**
     * Returns Type Dispute Details.
     */
    public function getTypeDisputeDetails(): ?PaymentBalanceActivityDisputeDetail
    {
        return $this->typeDisputeDetails;
    }

    /**
     * Sets Type Dispute Details.
     *
     * @maps type_dispute_details
     */
    public function setTypeDisputeDetails(?PaymentBalanceActivityDisputeDetail $typeDisputeDetails): void
    {
        $this->typeDisputeDetails = $typeDisputeDetails;
    }

    /**
     * Returns Type Fee Details.
     */
    public function getTypeFeeDetails(): ?PaymentBalanceActivityFeeDetail
    {
        return $this->typeFeeDetails;
    }

    /**
     * Sets Type Fee Details.
     *
     * @maps type_fee_details
     */
    public function setTypeFeeDetails(?PaymentBalanceActivityFeeDetail $typeFeeDetails): void
    {
        $this->typeFeeDetails = $typeFeeDetails;
    }

    /**
     * Returns Type Free Processing Details.
     */
    public function getTypeFreeProcessingDetails(): ?PaymentBalanceActivityFreeProcessingDetail
    {
        return $this->typeFreeProcessingDetails;
    }

    /**
     * Sets Type Free Processing Details.
     *
     * @maps type_free_processing_details
     */
    public function setTypeFreeProcessingDetails(
        ?PaymentBalanceActivityFreeProcessingDetail $typeFreeProcessingDetails
    ): void {
        $this->typeFreeProcessingDetails = $typeFreeProcessingDetails;
    }

    /**
     * Returns Type Hold Adjustment Details.
     */
    public function getTypeHoldAdjustmentDetails(): ?PaymentBalanceActivityHoldAdjustmentDetail
    {
        return $this->typeHoldAdjustmentDetails;
    }

    /**
     * Sets Type Hold Adjustment Details.
     *
     * @maps type_hold_adjustment_details
     */
    public function setTypeHoldAdjustmentDetails(
        ?PaymentBalanceActivityHoldAdjustmentDetail $typeHoldAdjustmentDetails
    ): void {
        $this->typeHoldAdjustmentDetails = $typeHoldAdjustmentDetails;
    }

    /**
     * Returns Type Open Dispute Details.
     */
    public function getTypeOpenDisputeDetails(): ?PaymentBalanceActivityOpenDisputeDetail
    {
        return $this->typeOpenDisputeDetails;
    }

    /**
     * Sets Type Open Dispute Details.
     *
     * @maps type_open_dispute_details
     */
    public function setTypeOpenDisputeDetails(?PaymentBalanceActivityOpenDisputeDetail $typeOpenDisputeDetails): void
    {
        $this->typeOpenDisputeDetails = $typeOpenDisputeDetails;
    }

    /**
     * Returns Type Other Details.
     */
    public function getTypeOtherDetails(): ?PaymentBalanceActivityOtherDetail
    {
        return $this->typeOtherDetails;
    }

    /**
     * Sets Type Other Details.
     *
     * @maps type_other_details
     */
    public function setTypeOtherDetails(?PaymentBalanceActivityOtherDetail $typeOtherDetails): void
    {
        $this->typeOtherDetails = $typeOtherDetails;
    }

    /**
     * Returns Type Other Adjustment Details.
     */
    public function getTypeOtherAdjustmentDetails(): ?PaymentBalanceActivityOtherAdjustmentDetail
    {
        return $this->typeOtherAdjustmentDetails;
    }

    /**
     * Sets Type Other Adjustment Details.
     *
     * @maps type_other_adjustment_details
     */
    public function setTypeOtherAdjustmentDetails(
        ?PaymentBalanceActivityOtherAdjustmentDetail $typeOtherAdjustmentDetails
    ): void {
        $this->typeOtherAdjustmentDetails = $typeOtherAdjustmentDetails;
    }

    /**
     * Returns Type Refund Details.
     */
    public function getTypeRefundDetails(): ?PaymentBalanceActivityRefundDetail
    {
        return $this->typeRefundDetails;
    }

    /**
     * Sets Type Refund Details.
     *
     * @maps type_refund_details
     */
    public function setTypeRefundDetails(?PaymentBalanceActivityRefundDetail $typeRefundDetails): void
    {
        $this->typeRefundDetails = $typeRefundDetails;
    }

    /**
     * Returns Type Release Adjustment Details.
     */
    public function getTypeReleaseAdjustmentDetails(): ?PaymentBalanceActivityReleaseAdjustmentDetail
    {
        return $this->typeReleaseAdjustmentDetails;
    }

    /**
     * Sets Type Release Adjustment Details.
     *
     * @maps type_release_adjustment_details
     */
    public function setTypeReleaseAdjustmentDetails(
        ?PaymentBalanceActivityReleaseAdjustmentDetail $typeReleaseAdjustmentDetails
    ): void {
        $this->typeReleaseAdjustmentDetails = $typeReleaseAdjustmentDetails;
    }

    /**
     * Returns Type Reserve Hold Details.
     */
    public function getTypeReserveHoldDetails(): ?PaymentBalanceActivityReserveHoldDetail
    {
        return $this->typeReserveHoldDetails;
    }

    /**
     * Sets Type Reserve Hold Details.
     *
     * @maps type_reserve_hold_details
     */
    public function setTypeReserveHoldDetails(?PaymentBalanceActivityReserveHoldDetail $typeReserveHoldDetails): void
    {
        $this->typeReserveHoldDetails = $typeReserveHoldDetails;
    }

    /**
     * Returns Type Reserve Release Details.
     */
    public function getTypeReserveReleaseDetails(): ?PaymentBalanceActivityReserveReleaseDetail
    {
        return $this->typeReserveReleaseDetails;
    }

    /**
     * Sets Type Reserve Release Details.
     *
     * @maps type_reserve_release_details
     */
    public function setTypeReserveReleaseDetails(
        ?PaymentBalanceActivityReserveReleaseDetail $typeReserveReleaseDetails
    ): void {
        $this->typeReserveReleaseDetails = $typeReserveReleaseDetails;
    }

    /**
     * Returns Type Square Capital Payment Details.
     */
    public function getTypeSquareCapitalPaymentDetails(): ?PaymentBalanceActivitySquareCapitalPaymentDetail
    {
        return $this->typeSquareCapitalPaymentDetails;
    }

    /**
     * Sets Type Square Capital Payment Details.
     *
     * @maps type_square_capital_payment_details
     */
    public function setTypeSquareCapitalPaymentDetails(
        ?PaymentBalanceActivitySquareCapitalPaymentDetail $typeSquareCapitalPaymentDetails
    ): void {
        $this->typeSquareCapitalPaymentDetails = $typeSquareCapitalPaymentDetails;
    }

    /**
     * Returns Type Square Capital Reversed Payment Details.
     */
    // phpcs:ignore
    public function getTypeSquareCapitalReversedPaymentDetails(): ?PaymentBalanceActivitySquareCapitalReversedPaymentDetail
    {
        return $this->typeSquareCapitalReversedPaymentDetails;
    }

    /**
     * Sets Type Square Capital Reversed Payment Details.
     *
     * @maps type_square_capital_reversed_payment_details
     */
    public function setTypeSquareCapitalReversedPaymentDetails(
        ?PaymentBalanceActivitySquareCapitalReversedPaymentDetail $typeSquareCapitalReversedPaymentDetails
    ): void {
        $this->typeSquareCapitalReversedPaymentDetails = $typeSquareCapitalReversedPaymentDetails;
    }

    /**
     * Returns Type Tax on Fee Details.
     */
    public function getTypeTaxOnFeeDetails(): ?PaymentBalanceActivityTaxOnFeeDetail
    {
        return $this->typeTaxOnFeeDetails;
    }

    /**
     * Sets Type Tax on Fee Details.
     *
     * @maps type_tax_on_fee_details
     */
    public function setTypeTaxOnFeeDetails(?PaymentBalanceActivityTaxOnFeeDetail $typeTaxOnFeeDetails): void
    {
        $this->typeTaxOnFeeDetails = $typeTaxOnFeeDetails;
    }

    /**
     * Returns Type Third Party Fee Details.
     */
    public function getTypeThirdPartyFeeDetails(): ?PaymentBalanceActivityThirdPartyFeeDetail
    {
        return $this->typeThirdPartyFeeDetails;
    }

    /**
     * Sets Type Third Party Fee Details.
     *
     * @maps type_third_party_fee_details
     */
    public function setTypeThirdPartyFeeDetails(
        ?PaymentBalanceActivityThirdPartyFeeDetail $typeThirdPartyFeeDetails
    ): void {
        $this->typeThirdPartyFeeDetails = $typeThirdPartyFeeDetails;
    }

    /**
     * Returns Type Third Party Fee Refund Details.
     */
    public function getTypeThirdPartyFeeRefundDetails(): ?PaymentBalanceActivityThirdPartyFeeRefundDetail
    {
        return $this->typeThirdPartyFeeRefundDetails;
    }

    /**
     * Sets Type Third Party Fee Refund Details.
     *
     * @maps type_third_party_fee_refund_details
     */
    public function setTypeThirdPartyFeeRefundDetails(
        ?PaymentBalanceActivityThirdPartyFeeRefundDetail $typeThirdPartyFeeRefundDetails
    ): void {
        $this->typeThirdPartyFeeRefundDetails = $typeThirdPartyFeeRefundDetails;
    }

    /**
     * Encode this object to JSON
     *
     * @param bool $asArrayWhenEmpty Whether to serialize this model as an array whenever no fields
     *        are set. (default: false)
     *
     * @return array|stdClass
     */
    #[\ReturnTypeWillChange] // @phan-suppress-current-line PhanUndeclaredClassAttribute for (php < 8.1)
    public function jsonSerialize(bool $asArrayWhenEmpty = false)
    {
        $json = [];
        $json['id']                                               = $this->id;
        $json['payout_id']                                        = $this->payoutId;
        if (!empty($this->effectiveAt)) {
            $json['effective_at']                                 = $this->effectiveAt['value'];
        }
        if (isset($this->type)) {
            $json['type']                                         = $this->type;
        }
        if (isset($this->grossAmountMoney)) {
            $json['gross_amount_money']                           = $this->grossAmountMoney;
        }
        if (isset($this->feeAmountMoney)) {
            $json['fee_amount_money']                             = $this->feeAmountMoney;
        }
        if (isset($this->netAmountMoney)) {
            $json['net_amount_money']                             = $this->netAmountMoney;
        }
        if (isset($this->typeAppFeeRevenueDetails)) {
            $json['type_app_fee_revenue_details']                 = $this->typeAppFeeRevenueDetails;
        }
        if (isset($this->typeAppFeeRefundDetails)) {
            $json['type_app_fee_refund_details']                  = $this->typeAppFeeRefundDetails;
        }
        if (isset($this->typeAutomaticSavingsDetails)) {
            $json['type_automatic_savings_details']               = $this->typeAutomaticSavingsDetails;
        }
        if (isset($this->typeAutomaticSavingsReversedDetails)) {
            $json['type_automatic_savings_reversed_details']      = $this->typeAutomaticSavingsReversedDetails;
        }
        if (isset($this->typeChargeDetails)) {
            $json['type_charge_details']                          = $this->typeChargeDetails;
        }
        if (isset($this->typeDepositFeeDetails)) {
            $json['type_deposit_fee_details']                     = $this->typeDepositFeeDetails;
        }
        if (isset($this->typeDisputeDetails)) {
            $json['type_dispute_details']                         = $this->typeDisputeDetails;
        }
        if (isset($this->typeFeeDetails)) {
            $json['type_fee_details']                             = $this->typeFeeDetails;
        }
        if (isset($this->typeFreeProcessingDetails)) {
            $json['type_free_processing_details']                 = $this->typeFreeProcessingDetails;
        }
        if (isset($this->typeHoldAdjustmentDetails)) {
            $json['type_hold_adjustment_details']                 = $this->typeHoldAdjustmentDetails;
        }
        if (isset($this->typeOpenDisputeDetails)) {
            $json['type_open_dispute_details']                    = $this->typeOpenDisputeDetails;
        }
        if (isset($this->typeOtherDetails)) {
            $json['type_other_details']                           = $this->typeOtherDetails;
        }
        if (isset($this->typeOtherAdjustmentDetails)) {
            $json['type_other_adjustment_details']                = $this->typeOtherAdjustmentDetails;
        }
        if (isset($this->typeRefundDetails)) {
            $json['type_refund_details']                          = $this->typeRefundDetails;
        }
        if (isset($this->typeReleaseAdjustmentDetails)) {
            $json['type_release_adjustment_details']              = $this->typeReleaseAdjustmentDetails;
        }
        if (isset($this->typeReserveHoldDetails)) {
            $json['type_reserve_hold_details']                    = $this->typeReserveHoldDetails;
        }
        if (isset($this->typeReserveReleaseDetails)) {
            $json['type_reserve_release_details']                 = $this->typeReserveReleaseDetails;
        }
        if (isset($this->typeSquareCapitalPaymentDetails)) {
            $json['type_square_capital_payment_details']          = $this->typeSquareCapitalPaymentDetails;
        }
        if (isset($this->typeSquareCapitalReversedPaymentDetails)) {
            $json['type_square_capital_reversed_payment_details'] = $this->typeSquareCapitalReversedPaymentDetails;
        }
        if (isset($this->typeTaxOnFeeDetails)) {
            $json['type_tax_on_fee_details']                      = $this->typeTaxOnFeeDetails;
        }
        if (isset($this->typeThirdPartyFeeDetails)) {
            $json['type_third_party_fee_details']                 = $this->typeThirdPartyFeeDetails;
        }
        if (isset($this->typeThirdPartyFeeRefundDetails)) {
            $json['type_third_party_fee_refund_details']          = $this->typeThirdPartyFeeRefundDetails;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
