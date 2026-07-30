<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\CatalogItemModifierListInfo;

/**
 * Builder for model CatalogItemModifierListInfo
 *
 * @see CatalogItemModifierListInfo
 */
class CatalogItemModifierListInfoBuilder
{
    /**
     * @var CatalogItemModifierListInfo
     */
    private $instance;

    private function __construct(CatalogItemModifierListInfo $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new catalog item modifier list info Builder object.
     */
    public static function init(string $modifierListId): self
    {
        return new self(new CatalogItemModifierListInfo($modifierListId));
    }

    /**
     * Sets modifier overrides field.
     */
    public function modifierOverrides(?array $value): self
    {
        $this->instance->setModifierOverrides($value);
        return $this;
    }

    /**
     * Unsets modifier overrides field.
     */
    public function unsetModifierOverrides(): self
    {
        $this->instance->unsetModifierOverrides();
        return $this;
    }

    /**
     * Sets min selected modifiers field.
     */
    public function minSelectedModifiers(?int $value): self
    {
        $this->instance->setMinSelectedModifiers($value);
        return $this;
    }

    /**
     * Unsets min selected modifiers field.
     */
    public function unsetMinSelectedModifiers(): self
    {
        $this->instance->unsetMinSelectedModifiers();
        return $this;
    }

    /**
     * Sets max selected modifiers field.
     */
    public function maxSelectedModifiers(?int $value): self
    {
        $this->instance->setMaxSelectedModifiers($value);
        return $this;
    }

    /**
     * Unsets max selected modifiers field.
     */
    public function unsetMaxSelectedModifiers(): self
    {
        $this->instance->unsetMaxSelectedModifiers();
        return $this;
    }

    /**
     * Sets enabled field.
     */
    public function enabled(?bool $value): self
    {
        $this->instance->setEnabled($value);
        return $this;
    }

    /**
     * Unsets enabled field.
     */
    public function unsetEnabled(): self
    {
        $this->instance->unsetEnabled();
        return $this;
    }

    /**
     * Initializes a new catalog item modifier list info object.
     */
    public function build(): CatalogItemModifierListInfo
    {
        return CoreHelper::clone($this->instance);
    }
}
