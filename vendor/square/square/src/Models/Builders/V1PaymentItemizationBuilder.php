<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\V1Money;
use Square\Models\V1PaymentItemDetail;
use Square\Models\V1PaymentItemization;

/**
 * Builder for model V1PaymentItemization
 *
 * @see V1PaymentItemization
 */
class V1PaymentItemizationBuilder
{
    /**
     * @var V1PaymentItemization
     */
    private $instance;

    private function __construct(V1PaymentItemization $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new v1 payment itemization Builder object.
     */
    public static function init(): self
    {
        return new self(new V1PaymentItemization());
    }

    /**
     * Sets name field.
     */
    public function name(?string $value): self
    {
        $this->instance->setName($value);
        return $this;
    }

    /**
     * Unsets name field.
     */
    public function unsetName(): self
    {
        $this->instance->unsetName();
        return $this;
    }

    /**
     * Sets quantity field.
     */
    public function quantity(?float $value): self
    {
        $this->instance->setQuantity($value);
        return $this;
    }

    /**
     * Unsets quantity field.
     */
    public function unsetQuantity(): self
    {
        $this->instance->unsetQuantity();
        return $this;
    }

    /**
     * Sets itemization type field.
     */
    public function itemizationType(?string $value): self
    {
        $this->instance->setItemizationType($value);
        return $this;
    }

    /**
     * Sets item detail field.
     */
    public function itemDetail(?V1PaymentItemDetail $value): self
    {
        $this->instance->setItemDetail($value);
        return $this;
    }

    /**
     * Sets notes field.
     */
    public function notes(?string $value): self
    {
        $this->instance->setNotes($value);
        return $this;
    }

    /**
     * Unsets notes field.
     */
    public function unsetNotes(): self
    {
        $this->instance->unsetNotes();
        return $this;
    }

    /**
     * Sets item variation name field.
     */
    public function itemVariationName(?string $value): self
    {
        $this->instance->setItemVariationName($value);
        return $this;
    }

    /**
     * Unsets item variation name field.
     */
    public function unsetItemVariationName(): self
    {
        $this->instance->unsetItemVariationName();
        return $this;
    }

    /**
     * Sets total money field.
     */
    public function totalMoney(?V1Money $value): self
    {
        $this->instance->setTotalMoney($value);
        return $this;
    }

    /**
     * Sets single quantity money field.
     */
    public function singleQuantityMoney(?V1Money $value): self
    {
        $this->instance->setSingleQuantityMoney($value);
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
     * Sets discount money field.
     */
    public function discountMoney(?V1Money $value): self
    {
        $this->instance->setDiscountMoney($value);
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
     * Sets taxes field.
     */
    public function taxes(?array $value): self
    {
        $this->instance->setTaxes($value);
        return $this;
    }

    /**
     * Unsets taxes field.
     */
    public function unsetTaxes(): self
    {
        $this->instance->unsetTaxes();
        return $this;
    }

    /**
     * Sets discounts field.
     */
    public function discounts(?array $value): self
    {
        $this->instance->setDiscounts($value);
        return $this;
    }

    /**
     * Unsets discounts field.
     */
    public function unsetDiscounts(): self
    {
        $this->instance->unsetDiscounts();
        return $this;
    }

    /**
     * Sets modifiers field.
     */
    public function modifiers(?array $value): self
    {
        $this->instance->setModifiers($value);
        return $this;
    }

    /**
     * Unsets modifiers field.
     */
    public function unsetModifiers(): self
    {
        $this->instance->unsetModifiers();
        return $this;
    }

    /**
     * Initializes a new v1 payment itemization object.
     */
    public function build(): V1PaymentItemization
    {
        return CoreHelper::clone($this->instance);
    }
}
