<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\CatalogIdMapping;

/**
 * Builder for model CatalogIdMapping
 *
 * @see CatalogIdMapping
 */
class CatalogIdMappingBuilder
{
    /**
     * @var CatalogIdMapping
     */
    private $instance;

    private function __construct(CatalogIdMapping $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new catalog id mapping Builder object.
     */
    public static function init(): self
    {
        return new self(new CatalogIdMapping());
    }

    /**
     * Sets client object id field.
     */
    public function clientObjectId(?string $value): self
    {
        $this->instance->setClientObjectId($value);
        return $this;
    }

    /**
     * Unsets client object id field.
     */
    public function unsetClientObjectId(): self
    {
        $this->instance->unsetClientObjectId();
        return $this;
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
     * Initializes a new catalog id mapping object.
     */
    public function build(): CatalogIdMapping
    {
        return CoreHelper::clone($this->instance);
    }
}
