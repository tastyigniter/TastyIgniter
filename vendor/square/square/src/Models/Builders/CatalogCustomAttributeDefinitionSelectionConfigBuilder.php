<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\CatalogCustomAttributeDefinitionSelectionConfig;

/**
 * Builder for model CatalogCustomAttributeDefinitionSelectionConfig
 *
 * @see CatalogCustomAttributeDefinitionSelectionConfig
 */
class CatalogCustomAttributeDefinitionSelectionConfigBuilder
{
    /**
     * @var CatalogCustomAttributeDefinitionSelectionConfig
     */
    private $instance;

    private function __construct(CatalogCustomAttributeDefinitionSelectionConfig $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new catalog custom attribute definition selection config Builder object.
     */
    public static function init(): self
    {
        return new self(new CatalogCustomAttributeDefinitionSelectionConfig());
    }

    /**
     * Sets max allowed selections field.
     */
    public function maxAllowedSelections(?int $value): self
    {
        $this->instance->setMaxAllowedSelections($value);
        return $this;
    }

    /**
     * Unsets max allowed selections field.
     */
    public function unsetMaxAllowedSelections(): self
    {
        $this->instance->unsetMaxAllowedSelections();
        return $this;
    }

    /**
     * Sets allowed selections field.
     */
    public function allowedSelections(?array $value): self
    {
        $this->instance->setAllowedSelections($value);
        return $this;
    }

    /**
     * Unsets allowed selections field.
     */
    public function unsetAllowedSelections(): self
    {
        $this->instance->unsetAllowedSelections();
        return $this;
    }

    /**
     * Initializes a new catalog custom attribute definition selection config object.
     */
    public function build(): CatalogCustomAttributeDefinitionSelectionConfig
    {
        return CoreHelper::clone($this->instance);
    }
}
