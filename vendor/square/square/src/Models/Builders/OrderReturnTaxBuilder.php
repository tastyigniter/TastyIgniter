<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\Money;
use Square\Models\OrderReturnTax;

/**
 * Builder for model OrderReturnTax
 *
 * @see OrderReturnTax
 */
class OrderReturnTaxBuilder
{
    /**
     * @var OrderReturnTax
     */
    private $instance;

    private function __construct(OrderReturnTax $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new order return tax Builder object.
     */
    public static function init(): self
    {
        return new self(new OrderReturnTax());
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
     * Sets source tax uid field.
     */
    public function sourceTaxUid(?string $value): self
    {
        $this->instance->setSourceTaxUid($value);
        return $this;
    }

    /**
     * Unsets source tax uid field.
     */
    public function unsetSourceTaxUid(): self
    {
        $this->instance->unsetSourceTaxUid();
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
     * Sets type field.
     */
    public function type(?string $value): self
    {
        $this->instance->setType($value);
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
     * Sets applied money field.
     */
    public function appliedMoney(?Money $value): self
    {
        $this->instance->setAppliedMoney($value);
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
     * Initializes a new order return tax object.
     */
    public function build(): OrderReturnTax
    {
        return CoreHelper::clone($this->instance);
    }
}
