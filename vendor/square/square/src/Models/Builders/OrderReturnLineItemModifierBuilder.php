<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\Money;
use Square\Models\OrderReturnLineItemModifier;

/**
 * Builder for model OrderReturnLineItemModifier
 *
 * @see OrderReturnLineItemModifier
 */
class OrderReturnLineItemModifierBuilder
{
    /**
     * @var OrderReturnLineItemModifier
     */
    private $instance;

    private function __construct(OrderReturnLineItemModifier $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new order return line item modifier Builder object.
     */
    public static function init(): self
    {
        return new self(new OrderReturnLineItemModifier());
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
     * Sets source modifier uid field.
     */
    public function sourceModifierUid(?string $value): self
    {
        $this->instance->setSourceModifierUid($value);
        return $this;
    }

    /**
     * Unsets source modifier uid field.
     */
    public function unsetSourceModifierUid(): self
    {
        $this->instance->unsetSourceModifierUid();
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
     * Sets base price money field.
     */
    public function basePriceMoney(?Money $value): self
    {
        $this->instance->setBasePriceMoney($value);
        return $this;
    }

    /**
     * Sets total price money field.
     */
    public function totalPriceMoney(?Money $value): self
    {
        $this->instance->setTotalPriceMoney($value);
        return $this;
    }

    /**
     * Sets quantity field.
     */
    public function quantity(?string $value): self
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
     * Initializes a new order return line item modifier object.
     */
    public function build(): OrderReturnLineItemModifier
    {
        return CoreHelper::clone($this->instance);
    }
}
