<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\Destination;

/**
 * Builder for model Destination
 *
 * @see Destination
 */
class DestinationBuilder
{
    /**
     * @var Destination
     */
    private $instance;

    private function __construct(Destination $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new destination Builder object.
     */
    public static function init(): self
    {
        return new self(new Destination());
    }

    /**
     * Sets type field.
     */
    public function type(?string $value): self
    {
        $this->instance->setType($value);
        return $this;
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
     * Initializes a new destination object.
     */
    public function build(): Destination
    {
        return CoreHelper::clone($this->instance);
    }
}
