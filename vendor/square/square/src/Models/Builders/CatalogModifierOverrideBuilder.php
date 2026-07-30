<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\CatalogModifierOverride;

/**
 * Builder for model CatalogModifierOverride
 *
 * @see CatalogModifierOverride
 */
class CatalogModifierOverrideBuilder
{
    /**
     * @var CatalogModifierOverride
     */
    private $instance;

    private function __construct(CatalogModifierOverride $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new catalog modifier override Builder object.
     */
    public static function init(string $modifierId): self
    {
        return new self(new CatalogModifierOverride($modifierId));
    }

    /**
     * Sets on by default field.
     */
    public function onByDefault(?bool $value): self
    {
        $this->instance->setOnByDefault($value);
        return $this;
    }

    /**
     * Unsets on by default field.
     */
    public function unsetOnByDefault(): self
    {
        $this->instance->unsetOnByDefault();
        return $this;
    }

    /**
     * Initializes a new catalog modifier override object.
     */
    public function build(): CatalogModifierOverride
    {
        return CoreHelper::clone($this->instance);
    }
}
