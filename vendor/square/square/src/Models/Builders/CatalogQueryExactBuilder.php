<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\CatalogQueryExact;

/**
 * Builder for model CatalogQueryExact
 *
 * @see CatalogQueryExact
 */
class CatalogQueryExactBuilder
{
    /**
     * @var CatalogQueryExact
     */
    private $instance;

    private function __construct(CatalogQueryExact $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new catalog query exact Builder object.
     */
    public static function init(string $attributeName, string $attributeValue): self
    {
        return new self(new CatalogQueryExact($attributeName, $attributeValue));
    }

    /**
     * Initializes a new catalog query exact object.
     */
    public function build(): CatalogQueryExact
    {
        return CoreHelper::clone($this->instance);
    }
}
