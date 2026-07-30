<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\CatalogCustomAttributeDefinition;
use Square\Models\CatalogCustomAttributeDefinitionNumberConfig;
use Square\Models\CatalogCustomAttributeDefinitionSelectionConfig;
use Square\Models\CatalogCustomAttributeDefinitionStringConfig;
use Square\Models\SourceApplication;

/**
 * Builder for model CatalogCustomAttributeDefinition
 *
 * @see CatalogCustomAttributeDefinition
 */
class CatalogCustomAttributeDefinitionBuilder
{
    /**
     * @var CatalogCustomAttributeDefinition
     */
    private $instance;

    private function __construct(CatalogCustomAttributeDefinition $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new catalog custom attribute definition Builder object.
     */
    public static function init(string $type, string $name, array $allowedObjectTypes): self
    {
        return new self(new CatalogCustomAttributeDefinition($type, $name, $allowedObjectTypes));
    }

    /**
     * Sets description field.
     */
    public function description(?string $value): self
    {
        $this->instance->setDescription($value);
        return $this;
    }

    /**
     * Unsets description field.
     */
    public function unsetDescription(): self
    {
        $this->instance->unsetDescription();
        return $this;
    }

    /**
     * Sets source application field.
     */
    public function sourceApplication(?SourceApplication $value): self
    {
        $this->instance->setSourceApplication($value);
        return $this;
    }

    /**
     * Sets seller visibility field.
     */
    public function sellerVisibility(?string $value): self
    {
        $this->instance->setSellerVisibility($value);
        return $this;
    }

    /**
     * Sets app visibility field.
     */
    public function appVisibility(?string $value): self
    {
        $this->instance->setAppVisibility($value);
        return $this;
    }

    /**
     * Sets string config field.
     */
    public function stringConfig(?CatalogCustomAttributeDefinitionStringConfig $value): self
    {
        $this->instance->setStringConfig($value);
        return $this;
    }

    /**
     * Sets number config field.
     */
    public function numberConfig(?CatalogCustomAttributeDefinitionNumberConfig $value): self
    {
        $this->instance->setNumberConfig($value);
        return $this;
    }

    /**
     * Sets selection config field.
     */
    public function selectionConfig(?CatalogCustomAttributeDefinitionSelectionConfig $value): self
    {
        $this->instance->setSelectionConfig($value);
        return $this;
    }

    /**
     * Sets custom attribute usage count field.
     */
    public function customAttributeUsageCount(?int $value): self
    {
        $this->instance->setCustomAttributeUsageCount($value);
        return $this;
    }

    /**
     * Sets key field.
     */
    public function key(?string $value): self
    {
        $this->instance->setKey($value);
        return $this;
    }

    /**
     * Unsets key field.
     */
    public function unsetKey(): self
    {
        $this->instance->unsetKey();
        return $this;
    }

    /**
     * Initializes a new catalog custom attribute definition object.
     */
    public function build(): CatalogCustomAttributeDefinition
    {
        return CoreHelper::clone($this->instance);
    }
}
