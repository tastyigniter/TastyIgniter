<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\Money;
use Square\Models\OrderServiceCharge;

/**
 * Builder for model OrderServiceCharge
 *
 * @see OrderServiceCharge
 */
class OrderServiceChargeBuilder
{
    /**
     * @var OrderServiceCharge
     */
    private $instance;

    private function __construct(OrderServiceCharge $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new order service charge Builder object.
     */
    public static function init(): self
    {
        return new self(new OrderServiceCharge());
    }

    /**
     * Sets uid field.
     */
    public function uid(?string $value): self
    {
        $this->instance->setUid($value);
        return $this;
    }

    /**
     * Unsets uid field.
     */
    public function unsetUid(): self
    {
        $this->instance->unsetUid();
        return $this;
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
     * Sets catalog object id field.
     */
    public function catalogObjectId(?string $value): self
    {
        $this->instance->setCatalogObjectId($value);
        return $this;
    }

    /**
     * Unsets catalog object id field.
     */
    public function unsetCatalogObjectId(): self
    {
        $this->instance->unsetCatalogObjectId();
        return $this;
    }

    /**
     * Sets catalog version field.
     */
    public function catalogVersion(?int $value): self
    {
        $this->instance->setCatalogVersion($value);
        return $this;
    }

    /**
     * Unsets catalog version field.
     */
    public function unsetCatalogVersion(): self
    {
        $this->instance->unsetCatalogVersion();
        return $this;
    }

    /**
     * Sets percentage field.
     */
    public function percentage(?string $value): self
    {
        $this->instance->setPercentage($value);
        return $this;
    }

    /**
     * Unsets percentage field.
     */
    public function unsetPercentage(): self
    {
        $this->instance->unsetPercentage();
        return $this;
    }

    /**
     * Sets amount money field.
     */
    public function amountMoney(?Money $value): self
    {
        $this->instance->setAmountMoney($value);
        return $this;
    }

    /**
     * Sets applied money field.
     */
    public function appliedMoney(?Money $value): self
    {
        $this->instance->setAppliedMoney($value);
        return $this;
    }

    /**
     * Sets total money field.
     */
    public function totalMoney(?Money $value): self
    {
        $this->instance->setTotalMoney($value);
        return $this;
    }

    /**
     * Sets total tax money field.
     */
    public function totalTaxMoney(?Money $value): self
    {
        $this->instance->setTotalTaxMoney($value);
        return $this;
    }

    /**
     * Sets calculation phase field.
     */
    public function calculationPhase(?string $value): self
    {
        $this->instance->setCalculationPhase($value);
        return $this;
    }

    /**
     * Sets taxable field.
     */
    public function taxable(?bool $value): self
    {
        $this->instance->setTaxable($value);
        return $this;
    }

    /**
     * Unsets taxable field.
     */
    public function unsetTaxable(): self
    {
        $this->instance->unsetTaxable();
        return $this;
    }

    /**
     * Sets applied taxes field.
     */
    public function appliedTaxes(?array $value): self
    {
        $this->instance->setAppliedTaxes($value);
        return $this;
    }

    /**
     * Unsets applied taxes field.
     */
    public function unsetAppliedTaxes(): self
    {
        $this->instance->unsetAppliedTaxes();
        return $this;
    }

    /**
     * Sets metadata field.
     */
    public function metadata(?array $value): self
    {
        $this->instance->setMetadata($value);
        return $this;
    }

    /**
     * Unsets metadata field.
     */
    public function unsetMetadata(): self
    {
        $this->instance->unsetMetadata();
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
     * Sets treatment type field.
     */
    public function treatmentType(?string $value): self
    {
        $this->instance->setTreatmentType($value);
        return $this;
    }

    /**
     * Sets scope field.
     */
    public function scope(?string $value): self
    {
        $this->instance->setScope($value);
        return $this;
    }

    /**
     * Initializes a new order service charge object.
     */
    public function build(): OrderServiceCharge
    {
        return CoreHelper::clone($this->instance);
    }
}
