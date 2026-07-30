<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\ListCatalogResponse;

/**
 * Builder for model ListCatalogResponse
 *
 * @see ListCatalogResponse
 */
class ListCatalogResponseBuilder
{
    /**
     * @var ListCatalogResponse
     */
    private $instance;

    private function __construct(ListCatalogResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new list catalog response Builder object.
     */
    public static function init(): self
    {
        return new self(new ListCatalogResponse());
    }

    /**
     * Sets errors field.
     */
    public function errors(?array $value): self
    {
        $this->instance->setErrors($value);
        return $this;
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
     * Sets objects field.
     */
    public function objects(?array $value): self
    {
        $this->instance->setObjects($value);
        return $this;
    }

    /**
     * Initializes a new list catalog response object.
     */
    public function build(): ListCatalogResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
