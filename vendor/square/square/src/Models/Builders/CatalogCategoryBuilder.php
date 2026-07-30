<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\CatalogCategory;

/**
 * Builder for model CatalogCategory
 *
 * @see CatalogCategory
 */
class CatalogCategoryBuilder
{
    /**
     * @var CatalogCategory
     */
    private $instance;

    private function __construct(CatalogCategory $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new catalog category Builder object.
     */
    public static function init(): self
    {
        return new self(new CatalogCategory());
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
     * Initializes a new catalog category object.
     */
    public function build(): CatalogCategory
    {
        return CoreHelper::clone($this->instance);
    }
}
