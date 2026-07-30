<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\V1Money;
use Square\Models\V1Refund;

/**
 * Builder for model V1Refund
 *
 * @see V1Refund
 */
class V1RefundBuilder
{
    /**
     * @var V1Refund
     */
    private $instance;

    private function __construct(V1Refund $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new v1 refund Builder object.
     */
    public static function init(): self
    {
        return new self(new V1Refund());
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
     * Sets reason field.
     */
    public function reason(?string $value): self
    {
        $this->instance->setReason($value);
        return $this;
    }

    /**
     * Unsets reason field.
     */
    public function unsetReason(): self
    {
        $this->instance->unsetReason();
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
     * Sets refunded processing fee money field.
     */
    public function refundedProcessingFeeMoney(?V1Money $value): self
    {
        $this->instance->setRefundedProcessingFeeMoney($value);
        return $this;
    }

    /**
     * Sets refunded tax money field.
     */
    public function refundedTaxMoney(?V1Money $value): self
    {
        $this->instance->setRefundedTaxMoney($value);
        return $this;
    }

    /**
     * Sets refunded additive tax money field.
     */
    public function refundedAdditiveTaxMoney(?V1Money $value): self
    {
        $this->instance->setRefundedAdditiveTaxMoney($value);
        return $this;
    }

    /**
     * Sets refunded additive tax field.
     */
    public function refundedAdditiveTax(?array $value): self
    {
        $this->instance->setRefundedAdditiveTax($value);
        return $this;
    }

    /**
     * Unsets refunded additive tax field.
     */
    public function unsetRefundedAdditiveTax(): self
    {
        $this->instance->unsetRefundedAdditiveTax();
        return $this;
    }

    /**
     * Sets refunded inclusive tax money field.
     */
    public function refundedInclusiveTaxMoney(?V1Money $value): self
    {
        $this->instance->setRefundedInclusiveTaxMoney($value);
        return $this;
    }

    /**
     * Sets refunded inclusive tax field.
     */
    public function refundedInclusiveTax(?array $value): self
    {
        $this->instance->setRefundedInclusiveTax($value);
        return $this;
    }

    /**
     * Unsets refunded inclusive tax field.
     */
    public function unsetRefundedInclusiveTax(): self
    {
        $this->instance->unsetRefundedInclusiveTax();
        return $this;
    }

    /**
     * Sets refunded tip money field.
     */
    public function refundedTipMoney(?V1Money $value): self
    {
        $this->instance->setRefundedTipMoney($value);
        return $this;
    }

    /**
     * Sets refunded discount money field.
     */
    public function refundedDiscountMoney(?V1Money $value): self
    {
        $this->instance->setRefundedDiscountMoney($value);
        return $this;
    }

    /**
     * Sets refunded surcharge money field.
     */
    public function refundedSurchargeMoney(?V1Money $value): self
    {
        $this->instance->setRefundedSurchargeMoney($value);
        return $this;
    }

    /**
     * Sets refunded surcharges field.
     */
    public function refundedSurcharges(?array $value): self
    {
        $this->instance->setRefundedSurcharges($value);
        return $this;
    }

    /**
     * Unsets refunded surcharges field.
     */
    public function unsetRefundedSurcharges(): self
    {
        $this->instance->unsetRefundedSurcharges();
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
     * Sets processed at field.
     */
    public function processedAt(?string $value): self
    {
        $this->instance->setProcessedAt($value);
        return $this;
    }

    /**
     * Unsets processed at field.
     */
    public function unsetProcessedAt(): self
    {
        $this->instance->unsetProcessedAt();
        return $this;
    }

    /**
     * Sets payment id field.
     */
    public function paymentId(?string $value): self
    {
        $this->instance->setPaymentId($value);
        return $this;
    }

    /**
     * Unsets payment id field.
     */
    public function unsetPaymentId(): self
    {
        $this->instance->unsetPaymentId();
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
     * Sets is exchange field.
     */
    public function isExchange(?bool $value): self
    {
        $this->instance->setIsExchange($value);
        return $this;
    }

    /**
     * Unsets is exchange field.
     */
    public function unsetIsExchange(): self
    {
        $this->instance->unsetIsExchange();
        return $this;
    }

    /**
     * Initializes a new v1 refund object.
     */
    public function build(): V1Refund
    {
        return CoreHelper::clone($this->instance);
    }
}
