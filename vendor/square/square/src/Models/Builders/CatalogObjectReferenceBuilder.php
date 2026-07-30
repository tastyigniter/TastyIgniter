<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\CatalogObjectReference;

/**
 * Builder for model CatalogObjectReference
 *
 * @see CatalogObjectReference
 */
class CatalogObjectReferenceBuilder
{
    /**
     * @var CatalogObjectReference
     */
    private $instance;

    private function __construct(CatalogObjectReference $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new catalog object reference Builder object.
     */
    public static function init(): self
    {
        return new self(new CatalogObjectReference());
    }

    /**
     * Sets object id field.
     */
    public function objectId(?string $value): self
    {
        $this->instance->setObjectId($value);
        return $this;
    }

    /**
     * Unsets object id field.
     */
    public function unsetObjectId(): self
    {
        $this->instance->unsetObjectId();
        return $this;
    }

    /**
     * Sets catalog version field.
     */
    public function catalogVersion(?int $value): self
    {
        $this->instance->setCatalogVersion($value);
        return $this;
    }

    /**
     * Unsets catalog version field.
     */
    public function unsetCatalogVersion(): self
    {
        $this->instance->unsetCatalogVersion();
        return $this;
    }

    /**
     * Initializes a new catalog object reference object.
     */
    public function build(): CatalogObjectReference
    {
        return CoreHelper::clone($this->instance);
    }
}
