<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\Device;
use Square\Models\V1Money;
use Square\Models\V1Payment;

/**
 * Builder for model V1Payment
 *
 * @see V1Payment
 */
class V1PaymentBuilder
{
    /**
     * @var V1Payment
     */
    private $instance;

    private function __construct(V1Payment $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new v1 payment Builder object.
     */
    public static function init(): self
    {
        return new self(new V1Payment());
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
     * Sets merchant id field.
     */
    public function merchantId(?string $value): self
    {
        $this->instance->setMerchantId($value);
        return $this;
    }

    /**
     * Unsets merchant id field.
     */
    public function unsetMerchantId(): self
    {
        $this->instance->unsetMerchantId();
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
     * Sets creator id field.
     */
    public function creatorId(?string $value): self
    {
        $this->instance->setCreatorId($value);
        return $this;
    }

    /**
     * Unsets creator id field.
     */
    public function unsetCreatorId(): self
    {
        $this->instance->unsetCreatorId();
        return $this;
    }

    /**
     * Sets device field.
     */
    public function device(?Device $value): self
    {
        $this->instance->setDevice($value);
        return $this;
    }

    /**
     * Sets payment url field.
     */
    public function paymentUrl(?string $value): self
    {
        $this->instance->setPaymentUrl($value);
        return $this;
    }

    /**
     * Unsets payment url field.
     */
    public function unsetPaymentUrl(): self
    {
        $this->instance->unsetPaymentUrl();
        return $this;
    }

    /**
     * Sets receipt url field.
     */
    public function receiptUrl(?string $value): self
    {
        $this->instance->setReceiptUrl($value);
        return $this;
    }

    /**
     * Unsets receipt url field.
     */
    public function unsetReceiptUrl(): self
    {
        $this->instance->unsetReceiptUrl();
        return $this;
    }

    /**
     * Sets inclusive tax money field.
     */
    public function inclusiveTaxMoney(?V1Money $value): self
    {
        $this->instance->setInclusiveTaxMoney($value);
        return $this;
    }

    /**
     * Sets additive tax money field.
     */
    public function additiveTaxMoney(?V1Money $value): self
    {
        $this->instance->setAdditiveTaxMoney($value);
        return $this;
    }

    /**
     * Sets tax money field.
     */
    public function taxMoney(?V1Money $value): self
    {
        $this->instance->setTaxMoney($value);
        return $this;
    }

    /**
     * Sets tip money field.
     */
    public function tipMoney(?V1Money $value): self
    {
        $this->instance->setTipMoney($value);
        return $this;
    }

    /**
     * Sets discount money field.
     */
    public function discountMoney(?V1Money $value): self
    {
        $this->instance->setDiscountMoney($value);
        return $this;
    }

    /**
     * Sets total collected money field.
     */
    public function totalCollectedMoney(?V1Money $value): self
    {
        $this->instance->setTotalCollectedMoney($value);
        return $this;
    }

    /**
     * Sets processing fee money field.
     */
    public function processingFeeMoney(?V1Money $value): self
    {
        $this->instance->setProcessingFeeMoney($value);
        return $this;
    }

    /**
     * Sets net total money field.
     */
    public function netTotalMoney(?V1Money $value): self
    {
        $this->instance->setNetTotalMoney($value);
        return $this;
    }

    /**
     * Sets refunded money field.
     */
    public function refundedMoney(?V1Money $value): self
    {
        $this->instance->setRefundedMoney($value);
        return $this;
    }

    /**
     * Sets swedish rounding money field.
     */
    public function swedishRoundingMoney(?V1Money $value): self
    {
        $this->instance->setSwedishRoundingMoney($value);
        return $this;
    }

    /**
     * Sets gross sales money field.
     */
    public function grossSalesMoney(?V1Money $value): self
    {
        $this->instance->setGrossSalesMoney($value);
        return $this;
    }

    /**
     * Sets net sales money field.
     */
    public function netSalesMoney(?V1Money $value): self
    {
        $this->instance->setNetSalesMoney($value);
        return $this;
    }

    /**
     * Sets inclusive tax field.
     */
    public function inclusiveTax(?array $value): self
    {
        $this->instance->setInclusiveTax($value);
        return $this;
    }

    /**
     * Unsets inclusive tax field.
     */
    public function unsetInclusiveTax(): self
    {
        $this->instance->unsetInclusiveTax();
        return $this;
    }

    /**
     * Sets additive tax field.
     */
    public function additiveTax(?array $value): self
    {
        $this->instance->setAdditiveTax($value);
        return $this;
    }

    /**
     * Unsets additive tax field.
     */
    public function unsetAdditiveTax(): self
    {
        $this->instance->unsetAdditiveTax();
        return $this;
    }

    /**
     * Sets tender field.
     */
    public function tender(?array $value): self
    {
        $this->instance->setTender($value);
        return $this;
    }

    /**
     * Unsets tender field.
     */
    public function unsetTender(): self
    {
        $this->instance->unsetTender();
        return $this;
    }

    /**
     * Sets refunds field.
     */
    public function refunds(?array $value): self
    {
        $this->instance->setRefunds($value);
        return $this;
    }

    /**
     * Unsets refunds field.
     */
    public function unsetRefunds(): self
    {
        $this->instance->unsetRefunds();
        return $this;
    }

    /**
     * Sets itemizations field.
     */
    public function itemizations(?array $value): self
    {
        $this->instance->setItemizations($value);
        return $this;
    }

    /**
     * Unsets itemizations field.
     */
    public function unsetItemizations(): self
    {
        $this->instance->unsetItemizations();
        return $this;
    }

    /**
     * Sets surcharge money field.
     */
    public function surchargeMoney(?V1Money $value): self
    {
        $this->instance->setSurchargeMoney($value);
        return $this;
    }

    /**
     * Sets surcharges field.
     */
    public function surcharges(?array $value): self
    {
        $this->instance->setSurcharges($value);
        return $this;
    }

    /**
     * Unsets surcharges field.
     */
    public function unsetSurcharges(): self
    {
        $this->instance->unsetSurcharges();
        return $this;
    }

    /**
     * Sets is partial field.
     */
    public function isPartial(?bool $value): self
    {
        $this->instance->setIsPartial($value);
        return $this;
    }

    /**
     * Unsets is partial field.
     */
    public function unsetIsPartial(): self
    {
        $this->instance->unsetIsPartial();
        return $this;
    }

    /**
     * Initializes a new v1 payment object.
     */
    public function build(): V1Payment
    {
        return CoreHelper::clone($this->instance);
    }
}
