<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\BreakType;

/**
 * Builder for model BreakType
 *
 * @see BreakType
 */
class BreakTypeBuilder
{
    /**
     * @var BreakType
     */
    private $instance;

    private function __construct(BreakType $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new break type Builder object.
     */
    public static function init(string $locationId, string $breakName, string $expectedDuration, bool $isPaid): self
    {
        return new self(new BreakType($locationId, $breakName, $expectedDuration, $isPaid));
    }

    /**
     * Sets id field.
     */
    public function id(?string $value): self
    {
        $this->instance->setId($value);
        return $this;
    }

    /**
     * Sets version field.
     */
    public function version(?int $value): self
    {
        $this->instance->setVersion($value);
        return $this;
    }

    /**
     * Sets created at field.
     */
    public function createdAt(?string $value): self
    {
        $this->instance->setCreatedAt($value);
        return $this;
    }

    /**
     * Sets updated at field.
     */
    public function updatedAt(?string $value): self
    {
        $this->instance->setUpdatedAt($value);
        return $this;
    }

    /**
     * Initializes a new break type object.
     */
    public function build(): BreakType
    {
        return CoreHelper::clone($this->instance);
    }
}
