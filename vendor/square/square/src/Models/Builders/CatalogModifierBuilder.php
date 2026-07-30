<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\CatalogModifier;
use Square\Models\Money;

/**
 * Builder for model CatalogModifier
 *
 * @see CatalogModifier
 */
class CatalogModifierBuilder
{
    /**
     * @var CatalogModifier
     */
    private $instance;

    private function __construct(CatalogModifier $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new catalog modifier Builder object.
     */
    public static function init(): self
    {
        return new self(new CatalogModifier());
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
     * Sets price money field.
     */
    public function priceMoney(?Money $value): self
    {
        $this->instance->setPriceMoney($value);
        return $this;
    }

    /**
     * Sets ordinal field.
     */
    public function ordinal(?int $value): self
    {
        $this->instance->setOrdinal($value);
        return $this;
    }

    /**
     * Unsets ordinal field.
     */
    public function unsetOrdinal(): self
    {
        $this->instance->unsetOrdinal();
        return $this;
    }

    /**
     * Sets modifier list id field.
     */
    public function modifierListId(?string $value): self
    {
        $this->instance->setModifierListId($value);
        return $this;
    }

    /**
     * Unsets modifier list id field.
     */
    public function unsetModifierListId(): self
    {
        $this->instance->unsetModifierListId();
        return $this;
    }

    /**
     * Sets image id field.
     */
    public function imageId(?string $value): self
    {
        $this->instance->setImageId($value);
        return $this;
    }

    /**
     * Unsets image id field.
     */
    public function unsetImageId(): self
    {
        $this->instance->unsetImageId();
        return $this;
    }

    /**
     * Initializes a new catalog modifier object.
     */
    public function build(): CatalogModifier
    {
        return CoreHelper::clone($this->instance);
    }
}
