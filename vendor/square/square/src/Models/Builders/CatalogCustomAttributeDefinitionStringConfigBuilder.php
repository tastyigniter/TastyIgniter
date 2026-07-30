<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\CatalogCustomAttributeDefinitionStringConfig;

/**
 * Builder for model CatalogCustomAttributeDefinitionStringConfig
 *
 * @see CatalogCustomAttributeDefinitionStringConfig
 */
class CatalogCustomAttributeDefinitionStringConfigBuilder
{
    /**
     * @var CatalogCustomAttributeDefinitionStringConfig
     */
    private $instance;

    private function __construct(CatalogCustomAttributeDefinitionStringConfig $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new catalog custom attribute definition string config Builder object.
     */
    public static function init(): self
    {
        return new self(new CatalogCustomAttributeDefinitionStringConfig());
    }

    /**
     * Sets enforce uniqueness field.
     */
    public function enforceUniqueness(?bool $value): self
    {
        $this->instance->setEnforceUniqueness($value);
        return $this;
    }

    /**
     * Unsets enforce uniqueness field.
     */
    public function unsetEnforceUniqueness(): self
    {
        $this->instance->unsetEnforceUniqueness();
        return $this;
    }

    /**
     * Initializes a new catalog custom attribute definition string config object.
     */
    public function build(): CatalogCustomAttributeDefinitionStringConfig
    {
        return CoreHelper::clone($this->instance);
    }
}
