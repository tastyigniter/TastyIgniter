<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\StandardUnitDescriptionGroup;

/**
 * Builder for model StandardUnitDescriptionGroup
 *
 * @see StandardUnitDescriptionGroup
 */
class StandardUnitDescriptionGroupBuilder
{
    /**
     * @var StandardUnitDescriptionGroup
     */
    private $instance;

    private function __construct(StandardUnitDescriptionGroup $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new standard unit description group Builder object.
     */
    public static function init(): self
    {
        return new self(new StandardUnitDescriptionGroup());
    }

    /**
     * Sets standard unit descriptions field.
     */
    public function standardUnitDescriptions(?array $value): self
    {
        $this->instance->setStandardUnitDescriptions($value);
        return $this;
    }

    /**
     * Unsets standard unit descriptions field.
     */
    public function unsetStandardUnitDescriptions(): self
    {
        $this->instance->unsetStandardUnitDescriptions();
        return $this;
    }

    /**
     * Sets language code field.
     */
    public function languageCode(?string $value): self
    {
        $this->instance->setLanguageCode($value);
        return $this;
    }

    /**
     * Unsets language code field.
     */
    public function unsetLanguageCode(): self
    {
        $this->instance->unsetLanguageCode();
        return $this;
    }

    /**
     * Initializes a new standard unit description group object.
     */
    public function build(): StandardUnitDescriptionGroup
    {
        return CoreHelper::clone($this->instance);
    }
}
