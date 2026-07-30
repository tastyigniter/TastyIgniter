<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\CatalogInfoResponse;
use Square\Models\CatalogInfoResponseLimits;
use Square\Models\StandardUnitDescriptionGroup;

/**
 * Builder for model CatalogInfoResponse
 *
 * @see CatalogInfoResponse
 */
class CatalogInfoResponseBuilder
{
    /**
     * @var CatalogInfoResponse
     */
    private $instance;

    private function __construct(CatalogInfoResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new catalog info response Builder object.
     */
    public static function init(): self
    {
        return new self(new CatalogInfoResponse());
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
     * Sets limits field.
     */
    public function limits(?CatalogInfoResponseLimits $value): self
    {
        $this->instance->setLimits($value);
        return $this;
    }

    /**
     * Sets standard unit description group field.
     */
    public function standardUnitDescriptionGroup(?StandardUnitDescriptionGroup $value): self
    {
        $this->instance->setStandardUnitDescriptionGroup($value);
        return $this;
    }

    /**
     * Initializes a new catalog info response object.
     */
    public function build(): CatalogInfoResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
