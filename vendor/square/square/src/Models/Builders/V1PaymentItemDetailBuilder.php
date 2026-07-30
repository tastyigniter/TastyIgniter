<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\V1PaymentItemDetail;

/**
 * Builder for model V1PaymentItemDetail
 *
 * @see V1PaymentItemDetail
 */
class V1PaymentItemDetailBuilder
{
    /**
     * @var V1PaymentItemDetail
     */
    private $instance;

    private function __construct(V1PaymentItemDetail $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new v1 payment item detail Builder object.
     */
    public static function init(): self
    {
        return new self(new V1PaymentItemDetail());
    }

    /**
     * Sets category name field.
     */
    public function categoryName(?string $value): self
    {
        $this->instance->setCategoryName($value);
        return $this;
    }

    /**
     * Unsets category name field.
     */
    public function unsetCategoryName(): self
    {
        $this->instance->unsetCategoryName();
        return $this;
    }

    /**
     * Sets sku field.
     */
    public function sku(?string $value): self
    {
        $this->instance->setSku($value);
        return $this;
    }

    /**
     * Unsets sku field.
     */
    public function unsetSku(): self
    {
        $this->instance->unsetSku();
        return $this;
    }

    /**
     * Sets item id field.
     */
    public function itemId(?string $value): self
    {
        $this->instance->setItemId($value);
        return $this;
    }

    /**
     * Unsets item id field.
     */
    public function unsetItemId(): self
    {
        $this->instance->unsetItemId();
        return $this;
    }

    /**
     * Sets item variation id field.
     */
    public function itemVariationId(?string $value): self
    {
        $this->instance->setItemVariationId($value);
        return $this;
    }

    /**
     * Unsets item variation id field.
     */
    public function unsetItemVariationId(): self
    {
        $this->instance->unsetItemVariationId();
        return $this;
    }

    /**
     * Initializes a new v1 payment item detail object.
     */
    public function build(): V1PaymentItemDetail
    {
        return CoreHelper::clone($this->instance);
    }
}
