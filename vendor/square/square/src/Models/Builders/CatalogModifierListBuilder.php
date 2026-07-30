<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\CatalogModifierList;

/**
 * Builder for model CatalogModifierList
 *
 * @see CatalogModifierList
 */
class CatalogModifierListBuilder
{
    /**
     * @var CatalogModifierList
     */
    private $instance;

    private function __construct(CatalogModifierList $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new catalog modifier list Builder object.
     */
    public static function init(): self
    {
        return new self(new CatalogModifierList());
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
     * Sets selection type field.
     */
    public function selectionType(?string $value): self
    {
        $this->instance->setSelectionType($value);
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
     * Sets image ids field.
     */
    public function imageIds(?array $value): self
    {
        $this->instance->setImageIds($value);
        return $this;
    }

    /**
     * Unsets image ids field.
     */
    public function unsetImageIds(): self
    {
        $this->instance->unsetImageIds();
        return $this;
    }

    /**
     * Initializes a new catalog modifier list object.
     */
    public function build(): CatalogModifierList
    {
        return CoreHelper::clone($this->instance);
    }
}
