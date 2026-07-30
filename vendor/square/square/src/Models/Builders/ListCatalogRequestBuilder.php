<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\ListCatalogRequest;

/**
 * Builder for model ListCatalogRequest
 *
 * @see ListCatalogRequest
 */
class ListCatalogRequestBuilder
{
    /**
     * @var ListCatalogRequest
     */
    private $instance;

    private function __construct(ListCatalogRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new list catalog request Builder object.
     */
    public static function init(): self
    {
        return new self(new ListCatalogRequest());
    }

    /**
     * Sets cursor field.
     */
    public function cursor(?string $value): self
    {
        $this->instance->setCursor($value);
        return $this;
    }

    /**
     * Unsets cursor field.
     */
    public function unsetCursor(): self
    {
        $this->instance->unsetCursor();
        return $this;
    }

    /**
     * Sets types field.
     */
    public function types(?string $value): self
    {
        $this->instance->setTypes($value);
        return $this;
    }

    /**
     * Unsets types field.
     */
    public function unsetTypes(): self
    {
        $this->instance->unsetTypes();
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
     * Initializes a new list catalog request object.
     */
    public function build(): ListCatalogRequest
    {
        return CoreHelper::clone($this->instance);
    }
}
