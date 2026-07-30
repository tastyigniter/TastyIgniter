<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\CatalogCustomAttributeDefinitionNumberConfig;

/**
 * Builder for model CatalogCustomAttributeDefinitionNumberConfig
 *
 * @see CatalogCustomAttributeDefinitionNumberConfig
 */
class CatalogCustomAttributeDefinitionNumberConfigBuilder
{
    /**
     * @var CatalogCustomAttributeDefinitionNumberConfig
     */
    private $instance;

    private function __construct(CatalogCustomAttributeDefinitionNumberConfig $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new catalog custom attribute definition number config Builder object.
     */
    public static function init(): self
    {
        return new self(new CatalogCustomAttributeDefinitionNumberConfig());
    }

    /**
     * Sets precision field.
     */
    public function precision(?int $value): self
    {
        $this->instance->setPrecision($value);
        return $this;
    }

    /**
     * Unsets precision field.
     */
    public function unsetPrecision(): self
    {
        $this->instance->unsetPrecision();
        return $this;
    }

    /**
     * Initializes a new catalog custom attribute definition number config object.
     */
    public function build(): CatalogCustomAttributeDefinitionNumberConfig
    {
        return CoreHelper::clone($this->instance);
    }
}
