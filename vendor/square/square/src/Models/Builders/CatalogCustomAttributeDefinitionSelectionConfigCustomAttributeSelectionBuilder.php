<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\CatalogCustomAttributeDefinitionSelectionConfigCustomAttributeSelection;

/**
 * Builder for model CatalogCustomAttributeDefinitionSelectionConfigCustomAttributeSelection
 *
 * @see CatalogCustomAttributeDefinitionSelectionConfigCustomAttributeSelection
 */
class CatalogCustomAttributeDefinitionSelectionConfigCustomAttributeSelectionBuilder
{
    /**
     * @var CatalogCustomAttributeDefinitionSelectionConfigCustomAttributeSelection
     */
    private $instance;

    private function __construct(CatalogCustomAttributeDefinitionSelectionConfigCustomAttributeSelection $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new catalog custom attribute definition selection config custom attribute selection
     * Builder object.
     */
    public static function init(string $name): self
    {
        return new self(new CatalogCustomAttributeDefinitionSelectionConfigCustomAttributeSelection($name));
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
     * Initializes a new catalog custom attribute definition selection config custom attribute selection
     * object.
     */
    public function build(): CatalogCustomAttributeDefinitionSelectionConfigCustomAttributeSelection
    {
        return CoreHelper::clone($this->instance);
    }
}
