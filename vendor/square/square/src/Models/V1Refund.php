<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * V1Refund
 */
class V1Refund implements \JsonSerializable
{
    /**
     * @var string|null
     */
    private $type;

    /**
     * @var array
     */
    private $reason = [];

    /**
     * @var V1Money|null
     */
    private $refundedMoney;

    /**
     * @var V1Money|null
     */
    private $refundedProcessingFeeMoney;

    /**
     * @var V1Money|null
     */
    private $refundedTaxMoney;

    /**
     * @var V1Money|null
     */
    private $refundedAdditiveTaxMoney;

    /**
     * @var array
     */
    private $refundedAdditiveTax = [];

    /**
     * @var V1Money|null
     */
    private $refundedInclusiveTaxMoney;

    /**
     * @var array
     */
    private $refundedInclusiveTax = [];

    /**
     * @var V1Money|null
     */
    private $refundedTipMoney;

    /**
     * @var V1Money|null
     */
    private $refundedDiscountMoney;

    /**
     * @var V1Money|null
     */
    private $refundedSurchargeMoney;

    /**
     * @var array
     */
    private $refundedSurcharges = [];

    /**
     * @var string|null
     */
    private $createdAt;

    /**
     * @var array
     */
    private $processedAt = [];

    /**
     * @var array
     */
    private $paymentId = [];

    /**
     * @var array
     */
    private $merchantId = [];

    /**
     * @var array
     */
    private $isExchange = [];

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
     * Returns Reason.
     * The merchant-specified reason for the refund.
     */
    public function getReason(): ?string
    {
        if (count($this->reason) == 0) {
            return null;
        }
        return $this->reason['value'];
    }

    /**
     * Sets Reason.
     * The merchant-specified reason for the refund.
     *
     * @maps reason
     */
    public function setReason(?string $reason): void
    {
        $this->reason['value'] = $reason;
    }

    /**
     * Unsets Reason.
     * The merchant-specified reason for the refund.
     */
    public function unsetReason(): void
    {
        $this->reason = [];
    }

    /**
     * Returns Refunded Money.
     */
    public function getRefundedMoney(): ?V1Money
    {
        return $this->refundedMoney;
    }

    /**
     * Sets Refunded Money.
     *
     * @maps refunded_money
     */
    public function setRefundedMoney(?V1Money $refundedMoney): void
    {
        $this->refundedMoney = $refundedMoney;
    }

    /**
     * Returns Refunded Processing Fee Money.
     */
    public function getRefundedProcessingFeeMoney(): ?V1Money
    {
        return $this->refundedProcessingFeeMoney;
    }

    /**
     * Sets Refunded Processing Fee Money.
     *
     * @maps refunded_processing_fee_money
     */
    public function setRefundedProcessingFeeMoney(?V1Money $refundedProcessingFeeMoney): void
    {
        $this->refundedProcessingFeeMoney = $refundedProcessingFeeMoney;
    }

    /**
     * Returns Refunded Tax Money.
     */
    public function getRefundedTaxMoney(): ?V1Money
    {
        return $this->refundedTaxMoney;
    }

    /**
     * Sets Refunded Tax Money.
     *
     * @maps refunded_tax_money
     */
    public function setRefundedTaxMoney(?V1Money $refundedTaxMoney): void
    {
        $this->refundedTaxMoney = $refundedTaxMoney;
    }

    /**
     * Returns Refunded Additive Tax Money.
     */
    public function getRefundedAdditiveTaxMoney(): ?V1Money
    {
        return $this->refundedAdditiveTaxMoney;
    }

    /**
     * Sets Refunded Additive Tax Money.
     *
     * @maps refunded_additive_tax_money
     */
    public function setRefundedAdditiveTaxMoney(?V1Money $refundedAdditiveTaxMoney): void
    {
        $this->refundedAdditiveTaxMoney = $refundedAdditiveTaxMoney;
    }

    /**
     * Returns Refunded Additive Tax.
     * All of the additive taxes associated with the refund.
     *
     * @return V1PaymentTax[]|null
     */
    public function getRefundedAdditiveTax(): ?array
    {
        if (count($this->refundedAdditiveTax) == 0) {
            return null;
        }
        return $this->refundedAdditiveTax['value'];
    }

    /**
     * Sets Refunded Additive Tax.
     * All of the additive taxes associated with the refund.
     *
     * @maps refunded_additive_tax
     *
     * @param V1PaymentTax[]|null $refundedAdditiveTax
     */
    public function setRefundedAdditiveTax(?array $refundedAdditiveTax): void
    {
        $this->refundedAdditiveTax['value'] = $refundedAdditiveTax;
    }

    /**
     * Unsets Refunded Additive Tax.
     * All of the additive taxes associated with the refund.
     */
    public function unsetRefundedAdditiveTax(): void
    {
        $this->refundedAdditiveTax = [];
    }

    /**
     * Returns Refunded Inclusive Tax Money.
     */
    public function getRefundedInclusiveTaxMoney(): ?V1Money
    {
        return $this->refundedInclusiveTaxMoney;
    }

    /**
     * Sets Refunded Inclusive Tax Money.
     *
     * @maps refunded_inclusive_tax_money
     */
    public function setRefundedInclusiveTaxMoney(?V1Money $refundedInclusiveTaxMoney): void
    {
        $this->refundedInclusiveTaxMoney = $refundedInclusiveTaxMoney;
    }

    /**
     * Returns Refunded Inclusive Tax.
     * All of the inclusive taxes associated with the refund.
     *
     * @return V1PaymentTax[]|null
     */
    public function getRefundedInclusiveTax(): ?array
    {
        if (count($this->refundedInclusiveTax) == 0) {
            return null;
        }
        return $this->refundedInclusiveTax['value'];
    }

    /**
     * Sets Refunded Inclusive Tax.
     * All of the inclusive taxes associated with the refund.
     *
     * @maps refunded_inclusive_tax
     *
     * @param V1PaymentTax[]|null $refundedInclusiveTax
     */
    public function setRefundedInclusiveTax(?array $refundedInclusiveTax): void
    {
        $this->refundedInclusiveTax['value'] = $refundedInclusiveTax;
    }

    /**
     * Unsets Refunded Inclusive Tax.
     * All of the inclusive taxes associated with the refund.
     */
    public function unsetRefundedInclusiveTax(): void
    {
        $this->refundedInclusiveTax = [];
    }

    /**
     * Returns Refunded Tip Money.
     */
    public function getRefundedTipMoney(): ?V1Money
    {
        return $this->refundedTipMoney;
    }

    /**
     * Sets Refunded Tip Money.
     *
     * @maps refunded_tip_money
     */
    public function setRefundedTipMoney(?V1Money $refundedTipMoney): void
    {
        $this->refundedTipMoney = $refundedTipMoney;
    }

    /**
     * Returns Refunded Discount Money.
     */
    public function getRefundedDiscountMoney(): ?V1Money
    {
        return $this->refundedDiscountMoney;
    }

    /**
     * Sets Refunded Discount Money.
     *
     * @maps refunded_discount_money
     */
    public function setRefundedDiscountMoney(?V1Money $refundedDiscountMoney): void
    {
        $this->refundedDiscountMoney = $refundedDiscountMoney;
    }

    /**
     * Returns Refunded Surcharge Money.
     */
    public function getRefundedSurchargeMoney(): ?V1Money
    {
        return $this->refundedSurchargeMoney;
    }

    /**
     * Sets Refunded Surcharge Money.
     *
     * @maps refunded_surcharge_money
     */
    public function setRefundedSurchargeMoney(?V1Money $refundedSurchargeMoney): void
    {
        $this->refundedSurchargeMoney = $refundedSurchargeMoney;
    }

    /**
     * Returns Refunded Surcharges.
     * A list of all surcharges associated with the refund.
     *
     * @return V1PaymentSurcharge[]|null
     */
    public function getRefundedSurcharges(): ?array
    {
        if (count($this->refundedSurcharges) == 0) {
            return null;
        }
        return $this->refundedSurcharges['value'];
    }

    /**
     * Sets Refunded Surcharges.
     * A list of all surcharges associated with the refund.
     *
     * @maps refunded_surcharges
     *
     * @param V1PaymentSurcharge[]|null $refundedSurcharges
     */
    public function setRefundedSurcharges(?array $refundedSurcharges): void
    {
        $this->refundedSurcharges['value'] = $refundedSurcharges;
    }

    /**
     * Unsets Refunded Surcharges.
     * A list of all surcharges associated with the refund.
     */
    public function unsetRefundedSurcharges(): void
    {
        $this->refundedSurcharges = [];
    }

    /**
     * Returns Created At.
     * The time when the merchant initiated the refund for Square to process, in ISO 8601 format.
     */
    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }

    /**
     * Sets Created At.
     * The time when the merchant initiated the refund for Square to process, in ISO 8601 format.
     *
     * @maps created_at
     */
    public function setCreatedAt(?string $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * Returns Processed At.
     * The time when Square processed the refund on behalf of the merchant, in ISO 8601 format.
     */
    public function getProcessedAt(): ?string
    {
        if (count($this->processedAt) == 0) {
            return null;
        }
        return $this->processedAt['value'];
    }

    /**
     * Sets Processed At.
     * The time when Square processed the refund on behalf of the merchant, in ISO 8601 format.
     *
     * @maps processed_at
     */
    public function setProcessedAt(?string $processedAt): void
    {
        $this->processedAt['value'] = $processedAt;
    }

    /**
     * Unsets Processed At.
     * The time when Square processed the refund on behalf of the merchant, in ISO 8601 format.
     */
    public function unsetProcessedAt(): void
    {
        $this->processedAt = [];
    }

    /**
     * Returns Payment Id.
     * A Square-issued ID associated with the refund. For single-tender refunds, payment_id is the ID of
     * the original payment ID. For split-tender refunds, payment_id is the ID of the original tender. For
     * exchange-based refunds (is_exchange == true), payment_id is the ID of the original payment ID even
     * if the payment includes other tenders.
     */
    public function getPaymentId(): ?string
    {
        if (count($this->paymentId) == 0) {
            return null;
        }
        return $this->paymentId['value'];
    }

    /**
     * Sets Payment Id.
     * A Square-issued ID associated with the refund. For single-tender refunds, payment_id is the ID of
     * the original payment ID. For split-tender refunds, payment_id is the ID of the original tender. For
     * exchange-based refunds (is_exchange == true), payment_id is the ID of the original payment ID even
     * if the payment includes other tenders.
     *
     * @maps payment_id
     */
    public function setPaymentId(?string $paymentId): void
    {
        $this->paymentId['value'] = $paymentId;
    }

    /**
     * Unsets Payment Id.
     * A Square-issued ID associated with the refund. For single-tender refunds, payment_id is the ID of
     * the original payment ID. For split-tender refunds, payment_id is the ID of the original tender. For
     * exchange-based refunds (is_exchange == true), payment_id is the ID of the original payment ID even
     * if the payment includes other tenders.
     */
    public function unsetPaymentId(): void
    {
        $this->paymentId = [];
    }

    /**
     * Returns Merchant Id.
     */
    public function getMerchantId(): ?string
    {
        if (count($this->merchantId) == 0) {
            return null;
        }
        return $this->merchantId['value'];
    }

    /**
     * Sets Merchant Id.
     *
     * @maps merchant_id
     */
    public function setMerchantId(?string $merchantId): void
    {
        $this->merchantId['value'] = $merchantId;
    }

    /**
     * Unsets Merchant Id.
     */
    public function unsetMerchantId(): void
    {
        $this->merchantId = [];
    }

    /**
     * Returns Is Exchange.
     * Indicates whether or not the refund is associated with an exchange. If is_exchange is true, the
     * refund reflects the value of goods returned in the exchange not the total money refunded.
     */
    public function getIsExchange(): ?bool
    {
        if (count($this->isExchange) == 0) {
            return null;
        }
        return $this->isExchange['value'];
    }

    /**
     * Sets Is Exchange.
     * Indicates whether or not the refund is associated with an exchange. If is_exchange is true, the
     * refund reflects the value of goods returned in the exchange not the total money refunded.
     *
     * @maps is_exchange
     */
    public function setIsExchange(?bool $isExchange): void
    {
        $this->isExchange['value'] = $isExchange;
    }

    /**
     * Unsets Is Exchange.
     * Indicates whether or not the refund is associated with an exchange. If is_exchange is true, the
     * refund reflects the value of goods returned in the exchange not the total money refunded.
     */
    public function unsetIsExchange(): void
    {
        $this->isExchange = [];
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
        if (isset($this->type)) {
            $json['type']                          = $this->type;
        }
        if (!empty($this->reason)) {
            $json['reason']                        = $this->reason['value'];
        }
        if (isset($this->refundedMoney)) {
            $json['refunded_money']                = $this->refundedMoney;
        }
        if (isset($this->refundedProcessingFeeMoney)) {
            $json['refunded_processing_fee_money'] = $this->refundedProcessingFeeMoney;
        }
        if (isset($this->refundedTaxMoney)) {
            $json['refunded_tax_money']            = $this->refundedTaxMoney;
        }
        if (isset($this->refundedAdditiveTaxMoney)) {
            $json['refunded_additive_tax_money']   = $this->refundedAdditiveTaxMoney;
        }
        if (!empty($this->refundedAdditiveTax)) {
            $json['refunded_additive_tax']         = $this->refundedAdditiveTax['value'];
        }
        if (isset($this->refundedInclusiveTaxMoney)) {
            $json['refunded_inclusive_tax_money']  = $this->refundedInclusiveTaxMoney;
        }
        if (!empty($this->refundedInclusiveTax)) {
            $json['refunded_inclusive_tax']        = $this->refundedInclusiveTax['value'];
        }
        if (isset($this->refundedTipMoney)) {
            $json['refunded_tip_money']            = $this->refundedTipMoney;
        }
        if (isset($this->refundedDiscountMoney)) {
            $json['refunded_discount_money']       = $this->refundedDiscountMoney;
        }
        if (isset($this->refundedSurchargeMoney)) {
            $json['refunded_surcharge_money']      = $this->refundedSurchargeMoney;
        }
        if (!empty($this->refundedSurcharges)) {
            $json['refunded_surcharges']           = $this->refundedSurcharges['value'];
        }
        if (isset($this->createdAt)) {
            $json['created_at']                    = $this->createdAt;
        }
        if (!empty($this->processedAt)) {
            $json['processed_at']                  = $this->processedAt['value'];
        }
        if (!empty($this->paymentId)) {
            $json['payment_id']                    = $this->paymentId['value'];
        }
        if (!empty($this->merchantId)) {
            $json['merchant_id']                   = $this->merchantId['value'];
        }
        if (!empty($this->isExchange)) {
            $json['is_exchange']                   = $this->isExchange['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
